<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageProxyController extends Controller
{
    /**
     * Proxy Cloudinary images to bypass ISP blocking
     */
    public function proxy(Request $request)
    {
        $url = $request->query('url');
        
        if (!$url) {
            return response()->json(['error' => 'URL parameter required'], 400);
        }

        // Validate Cloudinary URL
        if (!str_contains($url, 'res.cloudinary.com')) {
            return response()->json(['error' => 'Invalid Cloudinary URL'], 400);
        }

        try {
            // Create stream context with timeout
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ],
            ]);

            // Fetch image from Cloudinary
            $imageData = @file_get_contents($url, false, $context);

            if ($imageData === false) {
                return response()->json(['error' => 'Failed to fetch image from Cloudinary'], 502);
            }

            // Detect content type from URL extension
            $contentType = 'image/jpeg'; // default
            if (preg_match('/\.(jpg|jpeg)$/i', $url)) {
                $contentType = 'image/jpeg';
            } elseif (preg_match('/\.png$/i', $url)) {
                $contentType = 'image/png';
            } elseif (preg_match('/\.gif$/i', $url)) {
                $contentType = 'image/gif';
            } elseif (preg_match('/\.webp$/i', $url)) {
                $contentType = 'image/webp';
            }

            return response($imageData)
                ->header('Content-Type', $contentType)
                ->header('Cache-Control', 'public, max-age=31536000') // Cache 1 year
                ->header('Access-Control-Allow-Origin', '*');
                
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
