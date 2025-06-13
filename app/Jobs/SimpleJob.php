<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SimpleJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue,SerializesModels;
    protected $message;
    /**
     * Create a new job instance.
     */
    public function __construct($message)
    {
        $this->message=$message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Esecuzione del simple job:'. $this->message);
    }
}
