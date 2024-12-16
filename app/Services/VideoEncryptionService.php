<?php

namespace App\Services;

use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VideoEncryptionService
{
    /**
     * Encrypts the video using HLS encryption and saves it to the specified path.
     *
     * @param string $inputVideoPath The original video path.
     * @param string $outputVideoPath The path where the encrypted video will be saved.
     * @param string $encryptedVideoKeyPath
     * @return void
     */
    public static function encryptAndSave(string $inputVideoPath, string $outputVideoPath, string $encryptedVideoKeyPath): void
    {
        $highBitrate = (new X264)->setKiloBitrate(1000);
    
        // Open the video and apply HLS encryption
        FFMpeg::fromDisk('uploads')  // Assuming you're using the 'uploads' disk
            ->open($inputVideoPath)
            ->exportForHLS()
            ->withRotatingEncryptionKey(function ($filename, $content) use ($encryptedVideoKeyPath) {
                $keyFilename = basename($filename);
                $keyPath = $encryptedVideoKeyPath . '/' . $keyFilename;
                Storage::disk('uploads')->put($keyPath, $content);
            })
            ->onProgress(function ($percentage) {
                // Log or send progress to frontend
                Log::info("Encryption progress: {$percentage}%");
            })
            ->setSegmentLength(5)
            ->setKeyFrameInterval(48)
            ->addFormat($highBitrate)
            ->save($outputVideoPath);
    
        Storage::disk('uploads')->delete($inputVideoPath);
    }


}
