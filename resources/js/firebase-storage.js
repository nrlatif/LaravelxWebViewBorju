// Firebase Storage handler for image uploads
import { getStorage, ref, uploadBytesResumable, getDownloadURL, deleteObject } from 'firebase/storage';
import app from './firebase.js';

const storage = getStorage(app);

/**
 * Upload image to Firebase Storage
 * @param {File} file - Image file to upload
 * @param {Function} onProgress - Progress callback (optional)
 * @returns {Promise<string>} - Firebase Storage image URL
 */
export async function uploadImageToStorage(file, onProgress = null) {
    try {
        console.log('[Firebase Storage] Starting upload:', file.name);

        // Validate file type
        if (!file.type.startsWith('image/')) {
            throw new Error('File harus berupa gambar');
        }

        // Validate file size (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            throw new Error('Ukuran file maksimal 10MB');
        }

        // Generate unique filename
        const timestamp = Date.now();
        const fileName = `${timestamp}_${file.name.replace(/[^a-zA-Z0-9.]/g, '_')}`;
        const storageRef = ref(storage, `menus/${fileName}`);

        // Upload with progress tracking
        const uploadTask = uploadBytesResumable(storageRef, file);

        return new Promise((resolve, reject) => {
            uploadTask.on(
                'state_changed',
                (snapshot) => {
                    // Progress tracking
                    if (onProgress) {
                        const progress = Math.round((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
                        onProgress(progress);
                    }
                },
                (error) => {
                    // Error handling
                    console.error('[Firebase Storage] Upload error:', error);
                    reject(new Error('Upload gagal: ' + error.message));
                },
                async () => {
                    // Success - get download URL
                    try {
                        const downloadURL = await getDownloadURL(uploadTask.snapshot.ref);
                        console.log('[Firebase Storage] Upload successful:', downloadURL);
                        resolve(downloadURL);
                    } catch (error) {
                        reject(new Error('Gagal mendapatkan URL: ' + error.message));
                    }
                }
            );
        });
    } catch (error) {
        console.error('[Firebase Storage] Upload error:', error);
        throw error;
    }
}

/**
 * Generate image preview
 * @param {File} file - Image file
 * @returns {Promise<string>} - Base64 data URL for preview
 */
export function generateImagePreview(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            resolve(e.target.result);
        };
        
        reader.onerror = () => {
            reject(new Error('Failed to read file'));
        };
        
        reader.readAsDataURL(file);
    });
}

/**
 * Delete image from Firebase Storage
 * @param {string} imageUrl - Firebase Storage image URL
 * @returns {Promise<void>}
 */
export async function deleteImageFromStorage(imageUrl) {
    try {
        console.log('[Firebase Storage] Deleting image:', imageUrl);

        // Extract path from Firebase Storage URL
        const urlObj = new URL(imageUrl);
        const pathMatch = urlObj.pathname.match(/\/o\/(.+)$/);
        
        if (!pathMatch) {
            throw new Error('Invalid Firebase Storage URL');
        }

        const encodedPath = pathMatch[1];
        const filePath = decodeURIComponent(encodedPath.split('?')[0]);

        const fileRef = ref(storage, filePath);
        await deleteObject(fileRef);
        
        console.log('[Firebase Storage] Image deleted successfully');
    } catch (error) {
        console.error('[Firebase Storage] Delete error:', error);
        throw error;
    }
}
