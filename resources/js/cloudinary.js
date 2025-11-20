// Cloudinary upload handler
// Upload gambar ke Cloudinary dan return imageUrl

const CLOUDINARY_CLOUD_NAME = import.meta.env.VITE_CLOUDINARY_CLOUD_NAME;
const CLOUDINARY_UPLOAD_PRESET = import.meta.env.VITE_CLOUDINARY_UPLOAD_PRESET;

/**
 * Upload image to Cloudinary
 * @param {File} file - Image file to upload
 * @param {Function} onProgress - Progress callback (optional)
 * @returns {Promise<string>} - Cloudinary image URL
 */
export async function uploadImageToCloudinary(file, onProgress = null) {
    try {
        console.log('[Cloudinary] Starting upload:', file.name);

        // Validate file type
        if (!file.type.startsWith('image/')) {
            throw new Error('File harus berupa gambar');
        }

        // Validate file size (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            throw new Error('Ukuran file maksimal 10MB');
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);
        formData.append('folder', 'kp-borju/menus'); // Folder di Cloudinary

        const xhr = new XMLHttpRequest();
        
        return new Promise((resolve, reject) => {
            // Progress tracking
            if (onProgress) {
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        const percentComplete = Math.round((e.loaded / e.total) * 100);
                        onProgress(percentComplete);
                    }
                });
            }

            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    console.log('[Cloudinary] Upload successful:', response.secure_url);
                    resolve(response.secure_url);
                } else {
                    reject(new Error('Upload failed: ' + xhr.statusText));
                }
            });

            xhr.addEventListener('error', () => {
                reject(new Error('Network error during upload'));
            });

            xhr.open('POST', `https://api.cloudinary.com/v1_1/${CLOUDINARY_CLOUD_NAME}/image/upload`);
            xhr.send(formData);
        });
    } catch (error) {
        console.error('[Cloudinary] Upload error:', error);
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
 * Delete image from Cloudinary
 * @param {string} imageUrl - Cloudinary image URL
 * @returns {Promise<void>}
 */
export async function deleteImageFromCloudinary(imageUrl) {
    try {
        // Extract public_id from URL
        const urlParts = imageUrl.split('/');
        const publicIdWithExtension = urlParts.slice(urlParts.indexOf('kp-borju')).join('/');
        const publicId = publicIdWithExtension.replace(/\.[^/.]+$/, ''); // Remove extension

        console.log('[Cloudinary] Deleting image:', publicId);

        // Note: Deletion requires backend API because it needs API secret
        // For now, just log the public_id
        console.log('[Cloudinary] Public ID to delete:', publicId);
        console.warn('[Cloudinary] Image deletion requires backend implementation');

        // You can implement backend deletion endpoint here
        // await fetch('/api/cloudinary/delete', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ publicId })
        // });
    } catch (error) {
        console.error('[Cloudinary] Delete error:', error);
        throw error;
    }
}
