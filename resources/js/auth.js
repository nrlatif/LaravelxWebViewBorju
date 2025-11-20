import {
    createUserWithEmailAndPassword,
    signInWithEmailAndPassword,
    signOut,
    onAuthStateChanged,
    updateProfile,
} from 'firebase/auth';
import { doc, setDoc, getDoc } from 'firebase/firestore';
import { auth, db } from './firebase';

// Register function
export const register = async (email, password, fullName) => {
    try {
        console.log('[Auth] Starting registration for:', email);

        // Create user in Firebase Auth
        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;
        console.log('[Auth] User created in Firebase Auth:', user.uid);

        // Update user profile with full name
        await updateProfile(user, {
            displayName: fullName,
        });
        console.log('[Auth] User profile updated with displayName:', fullName);

        // Save user data to Firestore with default role 'kasir'
        console.log('[Firestore] Saving user data to collection "users"...');
        await setDoc(doc(db, 'users', user.uid), {
            uid: user.uid,
            email: email,
            fullName: fullName,
            role: 'kasir', // Default role is kasir, admin can be set manually in Firestore
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString(),
        });
        console.log('[Firestore] User data saved successfully!');

        return { success: true, user };
    } catch (error) {
        console.error('[Auth Error]', error.code, error.message);
        return { success: false, error: error.message };
    }
};

// Login function
export const login = async (email, password) => {
    try {
        console.log('[Auth] Starting login for:', email);

        const userCredential = await signInWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;
        console.log('[Auth] Login successful, UID:', user.uid);

        // Get user data from Firestore
        console.log('[Firestore] Fetching user data...');
        const userDoc = await getDoc(doc(db, 'users', user.uid));

        if (userDoc.exists()) {
            console.log('[Firestore] User data found:', userDoc.data());
        } else {
            console.warn('[Firestore] User document not found in Firestore');
        }

        return {
            success: true,
            user: {
                ...user,
                ...userDoc.data(),
            },
        };
    } catch (error) {
        console.error('[Auth Error]', error.code, error.message);
        return { success: false, error: error.message };
    }
};

// Logout function
export const logout = async () => {
    try {
        console.log('[Auth] Logging out...');
        await signOut(auth);
        console.log('[Auth] Logout successful');
        
        // Clear any session data
        try {
            sessionStorage.clear();
            localStorage.removeItem('kp_user');
        } catch (e) {
            console.warn('[Auth] Could not clear storage:', e);
        }
        
        return { success: true };
    } catch (error) {
        console.error('[Auth Error]', error.code, error.message);
        return { success: false, error: error.message };
    }
};

// Get current user
export const getCurrentUser = () => {
    return auth.currentUser;
};

// Monitor auth state
export const onAuthChange = (callback) => {
    return onAuthStateChanged(auth, async (user) => {
        console.log('[Auth] Auth state changed:', user ? 'Logged in' : 'Logged out');

        if (user) {
            // Get user data from Firestore
            try {
                console.log('[Firestore] Fetching user document for UID:', user.uid);
                const userDoc = await getDoc(doc(db, 'users', user.uid));
                
                if (userDoc.exists()) {
                    const userData = userDoc.data();
                    console.log('[Firestore] User data retrieved:', userData);
                    console.log('[Firestore] User role:', userData.role);
                    
                    // Merge Firebase Auth user with Firestore data
                    const mergedUser = {
                        ...user,
                        ...userData,
                    };
                    console.log('[Auth] Merged user data:', mergedUser);
                    callback(mergedUser);
                } else {
                    console.warn('[Firestore] User document does not exist for UID:', user.uid);
                    console.warn('[Firestore] Using default role: kasir');
                    callback({
                        ...user,
                        role: 'kasir', // Default role if no document exists
                    });
                }
            } catch (error) {
                console.error('[Firestore Error]', error);
                callback({
                    ...user,
                    role: 'kasir', // Default role on error
                });
            }
        } else {
            callback(null);
        }
    });
};
