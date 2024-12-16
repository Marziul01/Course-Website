<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class VideoController extends Controller
{
    public function stream($randomPath)
    {
        // Get the actual file path from the cache
        $filePath = Cache::get('video_' . $randomPath);

        // If no file path is found, abort with a 404 error
        if (!$filePath || !file_exists(public_path($filePath))) {
            abort(404, 'Video not found');
        }

        $fullPath = public_path($filePath);

        // Get MIME type of the file
        $mimeType = mime_content_type($fullPath);

        // Return the video file with appropriate headers
        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function generateVideoUrl($videoPath)
    {
        // Generate a random string
        $randomString = bin2hex(random_bytes(16));

        // Store the random string and map it to the correct video path in cache for 10 minutes
        Cache::put('video_' . $randomString, $videoPath, now()->addMinutes(10));

        return $randomString;
    }
}
