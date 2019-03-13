<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\AlertDetails;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Storage;

class TransferVideoToS3 extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $alertDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AlertDetails $alertDetails)
    {
        $this->alertDetails = $alertDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $filePath = 'videos/'. $this->alertDetails->user_code . '-' . $this->alertDetails->events . '.flv';
            $fileContents =  public_path($filePath);
            Log::debug("S3");
            Log::debug($fileContents);
            Storage::disk('s3')->put($filePath, file_get_contents($fileContents));
            if(Storage::disk('s3')->exists($filePath)){
               unlink($fileContents);
            }
            Log::debug("End S3");
        } catch(Exception $e) {
          echo Log::debug($e->getMessage());
            Log::debug("End S3");
        }
    }
}
