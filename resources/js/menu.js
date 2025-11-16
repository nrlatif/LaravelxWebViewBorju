import {
    collection,
    addDoc,
    updateDoc,
    deleteDoc,
    doc,
    getDocs,
    query,
    where,
    orderBy,
    onSnapshot
} from 'firebase/firestore';
import { db } from './firebase.js';
import { getCurrentUser } from './auth.js';

const MENUS_COLLECTION = 'menus';

/**
 * Get current user ID (optional - untuk new menus)
 */
async function getUserId() {
    try {
        const user = await getCurrentUser();
        return user ? user.uid : null;
    } catch (error) {
        return null;
    }
}

/**
 * Add new menu to Firestore
 * @param {Object} menuData - { name, price, priceBuy, kategori, description, detail, imageUrl, stok }
 * @returns {Promise<Object>} - Created menu with ID
 */
export async function addMenu(menuData) {
    try {
        const userId = await getUserId();

        console.log('[Menu] Adding new menu:', menuData);

        const docRef = await addDoc(collection(db, MENUS_COLLECTION), {
            ...menuData,
            userId: userId || null,
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString(),
            status: menuData.status !== undefined ? menuData.status : true,
            stok: menuData.stok || 0
        });

        console.log('[Menu] Menu added successfully with ID:', docRef.id);

        return {
            id: docRef.id,
            ...menuData,
            userId: userId || null,
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString(),
            status: menuData.status !== undefined ? menuData.status : true,
            stok: menuData.stok || 0
        };
    } catch (error) {
        console.error('[Menu] Error adding menu:', error);
        throw error;
    }
}

/**
 * Update existing menu
 * @param {string} menuId - Menu document ID
 * @param {Object} menuData - Updated menu data
 * @returns {Promise<void>}
 */
export async function updateMenu(menuId, menuData) {
    try {
        console.log('[Menu] Updating menu:', menuId);

        const menuRef = doc(db, MENUS_COLLECTION, menuId);
        await updateDoc(menuRef, {
            ...menuData,
            updatedAt: new Date().toISOString()
        });

        console.log('[Menu] Menu updated successfully:', menuId);
    } catch (error) {
        console.error('[Menu] Error updating menu:', error);
        throw error;
    }
}

/**
 * Delete menu from Firestore
 * @param {string} menuId - Menu document ID
 * @returns {Promise<void>}
 */
export async function deleteMenu(menuId) {
    try {
        console.log('[Menu] Deleting menu:', menuId);

        const menuRef = doc(db, MENUS_COLLECTION, menuId);
        await deleteDoc(menuRef);

        console.log('[Menu] Menu deleted successfully:', menuId);
    } catch (error) {
        console.error('[Menu] Error deleting menu:', error);
        throw error;
    }
}

/**
 * Get all menus
 * @returns {Promise<Array>} - Array of menu objects with IDs
 */
export async function getMenus() {
    try {
        console.log('[Menu] Fetching all menus from Firestore...');

        const q = query(
            collection(db, MENUS_COLLECTION),
            orderBy('createdAt', 'desc')
        );

        const querySnapshot = await getDocs(q);
        const menus = [];

        querySnapshot.forEach((doc) => {
            menus.push({
                id: doc.id,
                ...doc.data()
            });
        });

        console.log('[Menu] Fetched', menus.length, 'menus');
        return menus;
    } catch (error) {
        console.error('[Menu] Error fetching menus:', error);
        // Return empty array jika error (misal createdAt tidak ada di semua docs)
        try {
            const querySnapshot = await getDocs(collection(db, MENUS_COLLECTION));
            const menus = [];
            querySnapshot.forEach((doc) => {
                menus.push({
                    id: doc.id,
                    ...doc.data()
                });
            });
            console.log('[Menu] Fetched', menus.length, 'menus (without sorting)');
            return menus;
        } catch (fallbackError) {
            console.error('[Menu] Fallback error:', fallbackError);
            return [];
        }
    }
}

/**
 * Real-time listener for menus
 * @param {Function} callback - Function to call when menus change
 * @returns {Function} - Unsubscribe function
 */
export async function onMenusChange(callback) {
    try {
        console.log('[Menu] Setting up real-time listener for menus');

        const q = query(
            collection(db, MENUS_COLLECTION),
            orderBy('createdAt', 'desc')
        );

        const unsubscribe = onSnapshot(q, (querySnapshot) => {
            const menus = [];

            querySnapshot.forEach((doc) => {
                menus.push({
                    id: doc.id,
                    ...doc.data()
                });
            });

            console.log('[Menu] Real-time update: ', menus.length, 'menus');
            callback(menus);
        }, (error) => {
            console.error('[Menu] Real-time listener error:', error);
            // Try without ordering if error
            const fallbackUnsubscribe = onSnapshot(collection(db, MENUS_COLLECTION), (querySnapshot) => {
                const menus = [];
                querySnapshot.forEach((doc) => {
                    menus.push({
                        id: doc.id,
                        ...doc.data()
                    });
                });
                console.log('[Menu] Fallback real-time update: ', menus.length, 'menus');
                callback(menus);
            });
            return fallbackUnsubscribe;
        });

        return unsubscribe;
    } catch (error) {
        console.error('[Menu] Error setting up listener:', error);
        throw error;
    }
}

/**
 * Search menus by name
 * @param {string} searchQuery - Search query
 * @returns {Promise<Array>} - Filtered menus
 */
export async function searchMenus(searchQuery) {
    try {
        const query_str = searchQuery.toLowerCase();

        console.log('[Menu] Searching menus with query:', query_str);

        const querySnapshot = await getDocs(collection(db, MENUS_COLLECTION));
        const menus = [];

        querySnapshot.forEach((doc) => {
            const menu = {
                id: doc.id,
                ...doc.data()
            };

            // Client-side filtering
            const name = (menu.name || '').toLowerCase();
            const kategori = (menu.kategori || '').toLowerCase();
            const description = (menu.description || '').toLowerCase();

            if (name.includes(query_str) || kategori.includes(query_str) || description.includes(query_str)) {
                menus.push(menu);
            }
        });

        console.log('[Menu] Found', menus.length, 'matching menus');
        return menus;
    } catch (error) {
        console.error('[Menu] Error searching menus:', error);
        return [];
    }
}

/**
 * Get menu count
 * @returns {Promise<number>} - Number of menus
 */
export async function getMenuCount() {
    try {
        const querySnapshot = await getDocs(collection(db, MENUS_COLLECTION));
        return querySnapshot.size;
    } catch (error) {
        console.error('[Menu] Error getting menu count:', error);
        return 0;
    }
}
