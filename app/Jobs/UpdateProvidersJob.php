<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProvidersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {		
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' Providers update job start' , FILE_APPEND);
        $dingController = app(\App\Http\Controllers\ApiDingController::class);
		$dingController->data_update();
        $reloadlyController = app(\App\Http\Controllers\ApiReloadlyController::class);
		$reloadlyController->data_update();
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' job finished, providers updated' , FILE_APPEND);
    }
}
