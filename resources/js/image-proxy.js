// Image proxy helper to bypass ISP blocking Cloudinary
// Converts Cloudinary URL to proxied URL through Laravel

/**
 * Convert Cloudinary URL to proxied URL
 * @param {string} cloudinaryUrl - Original Cloudinary URL
 * @returns {string} - Proxied URL through Laravel
 */
export function getProxiedImageUrl(cloudinaryUrl) {
    if (!cloudinaryUrl) return '';
    
    // If already a proxied URL, return as is
    if (cloudinaryUrl.includes('/image-proxy?url=')) {
        return cloudinaryUrl;
    }
    
    // If not a Cloudinary URL, return as is
    if (!cloudinaryUrl.includes('res.cloudinary.com')) {
        return cloudinaryUrl;
    }
    
    // Convert to proxied URL
    const encodedUrl = encodeURIComponent(cloudinaryUrl);
    return `/image-proxy?url=${encodedUrl}`;
}

/**
 * Get original Cloudinary URL from proxied URL
 * @param {string} proxiedUrl - Proxied URL
 * @returns {string} - Original Cloudinary URL
 */
export function getOriginalImageUrl(proxiedUrl) {
    if (!proxiedUrl || !proxiedUrl.includes('/image-proxy?url=')) {
        return proxiedUrl;
    }
    
    const urlMatch = proxiedUrl.match(/url=([^&]+)/);
    if (urlMatch) {
        return decodeURIComponent(urlMatch[1]);
    }
    
    return proxiedUrl;
}
