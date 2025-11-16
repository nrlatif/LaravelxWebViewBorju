import { db } from './firebase.js';
import {
    collection,
    addDoc,
    getDocs,
    query,
    orderBy,
    onSnapshot,
    doc,
    getDoc,
    runTransaction,
    serverTimestamp,
    increment,
    deleteDoc
} from 'firebase/firestore';

const ordersCollection = collection(db, 'orders');
const statsDocRef = doc(db, 'meta', 'statistics');

async function createOrder(order) {
    try {
        // Ensure order has a subtotal/total as numbers
        const payload = Object.assign({}, order, {
            subtotal: Number(order.subtotal) || 0,
            tax: Number(order.tax) || 0,
            total: Number(order.total) || 0,
            createdAt: serverTimestamp()
        });

        // Use the order's local id (e.g., "ORD-1234567890") as the Firestore document ID
        // This way, order.id in the UI matches the Firestore doc ID for deletion
        const docId = order.id || ('ORD-' + Date.now());
        const docRef = doc(ordersCollection, docId);

        await runTransaction(db, async (tx) => {
            // READ first: get current stats
            const statsSnap = await tx.get(statsDocRef);

            // WRITE after reads: set order and update stats
            tx.set(docRef, payload);

            if (statsSnap.exists()) {
                tx.update(statsDocRef, {
                    totalOrders: increment(1),
                    totalRevenue: increment(payload.total),
                    lastOrderAt: serverTimestamp()
                });
            } else {
                tx.set(statsDocRef, {
                    totalOrders: 1,
                    totalRevenue: payload.total,
                    lastOrderAt: serverTimestamp()
                });
            }
        });

        return { success: true, id: docId };
    } catch (error) {
        console.error('[orders] createOrder error:', error);
        return { success: false, error: (error && error.message) ? error.message : String(error) };
    }
}

async function getOrders(limit = 100) {
    try {
        const q = query(ordersCollection, orderBy('createdAt', 'desc'));
        const snap = await getDocs(q);
        const items = snap.docs.map(d => ({ id: d.id, ...d.data() }));
        return items;
    } catch (error) {
        console.error('[orders] getOrders error:', error);
        return [];
    }
}

function onOrdersChange(cb) {
    try {
        const q = query(ordersCollection, orderBy('createdAt', 'desc'));
        const unsub = onSnapshot(q, (snapshot) => {
            const items = snapshot.docs.map(d => ({ id: d.id, ...d.data() }));
            try { cb(null, items); } catch (e) { console.error(e); }
        }, (err) => {
            console.error('[orders] onOrdersChange snapshot error:', err);
            try { cb(err); } catch (e) { console.error(e); }
        });
        return unsub;
    } catch (error) {
        console.error('[orders] onOrdersChange setup error:', error);
        return null;
    }
}

async function getOrderCount() {
    try {
        const q = query(ordersCollection);
        const snap = await getDocs(q);
        return snap.size || 0;
    } catch (error) {
        console.error('[orders] getOrderCount error:', error);
        return 0;
    }
}

async function getStatistics() {
    try {
        // PRIMARY: Calculate from orders collection (always accurate)
        console.log('[orders] getStatistics: Calculating from orders collection...');
        const ordersSnap = await getDocs(ordersCollection);
        const stats = {
            totalOrders: ordersSnap.size,
            totalRevenue: ordersSnap.docs.reduce((sum, doc) => sum + (Number(doc.data().total) || 0), 0),
            completedOrders: ordersSnap.docs.filter(doc => doc.data().status === 'completed').length
        };
        console.log('[orders] Calculated statistics:', stats);
        return stats;
    } catch (error) {
        console.error('[orders] getStatistics error:', error);
        return null;
    }
}

async function deleteOrder(orderId) {
    try {
        console.log('[orders] deleteOrder called for:', orderId);
        const orderRef = doc(db, 'orders', orderId);

        await runTransaction(db, async (tx) => {
            // READ first: get order and stats
            const orderSnap = await tx.get(orderRef);
            if (!orderSnap.exists()) throw new Error('Order not found');
            const data = orderSnap.data();
            console.log('[orders] Order found, total:', data.total);

            const statsSnap = await tx.get(statsDocRef);
            console.log('[orders] Stats before delete:', statsSnap.exists() ? statsSnap.data() : 'not found');

            // WRITE after reads: delete order and update stats
            tx.delete(orderRef);
            if (statsSnap.exists()) {
                const decrementAmount = Number(data.total) || 0;
                console.log('[orders] Decrementing revenue by:', decrementAmount);
                tx.update(statsDocRef, {
                    totalOrders: increment(-1),
                    totalRevenue: increment(-decrementAmount)
                });
            }
        });

        console.log('[orders] Order deleted successfully, stats should be updated');
        return { success: true };
    } catch (error) {
        console.error('[orders] deleteOrder error:', error);
        return { success: false, error: (error && error.message) ? error.message : String(error) };
    }
}

function onStatisticsChange(cb) {
    try {
        // PRIMARY: Listen to orders collection for real-time, accurate statistics
        // (This is the single source of truth since it auto-calculates from actual orders)
        const ordersQuery = query(ordersCollection);
        const unsub = onSnapshot(ordersQuery, (snapshot) => {
            const stats = {
                totalOrders: snapshot.size,
                totalRevenue: snapshot.docs.reduce((sum, doc) => sum + (Number(doc.data().total) || 0), 0),
                completedOrders: snapshot.docs.filter(doc => doc.data().status === 'completed').length
            };
            console.log('[orders] Statistics listener triggered (from orders collection):', stats);
            try { cb(null, stats); } catch (e) { console.error(e); }
        }, (err) => {
            console.error('[orders] onStatisticsChange snapshot error on orders:', err);
            try { cb(err); } catch (e) { console.error(e); }
        });

        return unsub;
    } catch (error) {
        console.error('[orders] onStatisticsChange setup error:', error);
        return null;
    }
}

export { createOrder, getOrders, onOrdersChange, getOrderCount, getStatistics, deleteOrder, onStatisticsChange };

