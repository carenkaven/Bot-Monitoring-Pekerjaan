<?php

namespace App\Traits;

trait RotatesPortraitImages
{
    /**
     * Pastikan gambar landscape. Jika portrait, putar dan simpan menimpa aslinya.
     * Menggunakan PowerShell (System.Drawing) karena ekstensi GD di PHP ini tidak mendukung JPEG.
     */
    protected function ensureLandscapeImage(string $path): void
    {
        if (!file_exists($path)) {
            return;
        }

        $size = @getimagesize($path);
        if (!$size) {
            return;
        }

        $width = $size[0];
        $height = $size[1];

        // Jika height > width, berarti potrait
        if ($height > $width) {
            // Gunakan PowerShell untuk merotasi gambar secara native di Windows
            $escapedPath = escapeshellarg($path);
            $psScript = "Add-Type -AssemblyName System.Drawing; "
                      . "\$img = [System.Drawing.Image]::FromFile($escapedPath); "
                      . "\$img.RotateFlip('Rotate270FlipNone'); "
                      . "\$img.Save($escapedPath); "
                      . "\$img.Dispose();";

            // Jalankan command
            exec("powershell -ExecutionPolicy Bypass -Command \"$psScript\"");
        }
    }
}
