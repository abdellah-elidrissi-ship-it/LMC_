<?php

if (!function_exists('cloudinary_url')) {
    function cloudinary_url($publicId, $options = [])
    {
        if (empty($publicId)) {
            return null;
        }
        
        // Si c'est déjà une URL complète
        if (filter_var($publicId, FILTER_VALIDATE_URL)) {
            return $publicId;
        }
        
        try {
            return cloudinary()->getUrl($publicId, $options);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Échec de génération d\'URL Cloudinary', [
                'public_id' => $publicId,
                'error' => $e->getMessage(),
            ]);
            // Fallback vers storage local
            return asset('storage/preuves/' . $publicId);
        }
    }
}