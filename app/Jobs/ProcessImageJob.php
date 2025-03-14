<?php

namespace App\Jobs;

use Intervention\Image\Facades\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $imagePath;
    protected $width;
    protected $height;
    protected $quality;

    /**
     * Create a new job instance.
     *
     * @param mixed $file
     * @param string $imagePath
     * @param int|null $width
     * @param int|null $height
     * @param int $quality
     */
    public function __construct($file, $imagePath, $width = 1500, $height = null, $quality = 50)
    {
        $this->file = $file;
        $this->imagePath = $imagePath;
        $this->width = $width;
        $this->height = $height;
        $this->quality = $quality;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $img = Image::make($this->file->getRealPath());
        $img->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // حفظ الصورة المضغوطة
        $img->save(storage_path('app/public/' . $this->imagePath), $this->quality);
    }
}
