<?php

namespace App\Console\Commands;



use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

class VideoEncode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:video-encode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        $this->info('Conerting Video.mp4');


        FFMpeg::fromDisk('uploads')
        ->open('Full_lifetime_access.mp4')
        ->exportForHLS()
        ->withRotatingEncryptionKey(function($filename,$content){
            Storage::disk('uploads')->put($filename,$content);
        })
        ->setSegmentLength(5) // optional
        ->setKeyFrameInterval(48) // optional
        ->addFormat($lowBitrate)
        ->addFormat($midBitrate)
        ->addFormat($highBitrate)
        ->save('adaptive_steve.m3u8');

        $this->info('Done');
    }
}
