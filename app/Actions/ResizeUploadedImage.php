<?php
declare(strict_types=1);

namespace App\Actions;

class ResizeUploadedImage {
    /**
     * Resizes and converts an image to web-optimized WebP or JPEG.
     *
     * @param string $sourcePath Full path to source image
     * @param string $destinationPath Target destination file path
     * @param int $maxWidth Max width constraint
     * @param int $maxHeight Max height constraint
     * @param int $quality Compression quality (1-100)
     * @return bool Success status
     */
    public function handle(
        string $sourcePath,
        string $destinationPath,
        int $maxWidth = 1920,
        int $maxHeight = 1080,
        int $quality = 85
    ): bool {
        if (!file_exists($sourcePath) || !extension_loaded('gd')) {
            return false;
        }

        $info = getimagesize($sourcePath);
        if (!$info) return false;

        [$origWidth, $origHeight, $imageType] = $info;

        // Calculate aspect-ratio preserved dimensions
        $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
        $newWidth = ($ratio < 1) ? (int)round($origWidth * $ratio) : $origWidth;
        $newHeight = ($ratio < 1) ? (int)round($origHeight * $ratio) : $origHeight;

        $sourceImg = match ($imageType) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG  => imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($sourcePath) : false,
            default        => false,
        };

        if (!$sourceImg) return false;

        $targetImg = imagecreatetruecolor($newWidth, $newHeight);

        // Retain transparency for PNG/WebP
        if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_WEBP) {
            imagealphablending($targetImg, false);
            imagesavealpha($targetImg, true);
            $transparent = imagecolorallocatealpha($targetImg, 255, 255, 255, 127);
            imagefilledrectangle($targetImg, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($targetImg, $sourceImg, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Ensure parent directory exists
        $dir = dirname($destinationPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));
        $success = match ($ext) {
            'webp' => function_exists('imagewebp') ? imagewebp($targetImg, $destinationPath, $quality) : false,
            'png'  => imagepng($targetImg, $destinationPath, (int)round((100 - $quality) / 10)),
            default => imagejpeg($targetImg, $destinationPath, $quality),
        };

        imagedestroy($sourceImg);
        imagedestroy($targetImg);

        return (bool)$success;
    }
}
