<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateProviders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateProviders'; // Nota deve essere uguale al command impostato sul Kernel

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UpdateProviders';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //Azione da eseguire qui ad esempio update database etc

        //success stampato in console
        $this->info("Azione avviata");		
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' Providers update start' , FILE_APPEND);
		$dingController = app(\App\Http\Controllers\ApiDingController::class);
		$dingController->data_update();	
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' Ding OK' , FILE_APPEND);
        $this->info("Ding OK");	
        $reloadlyController = app(\App\Http\Controllers\ApiReloadlyController::class);
		$reloadlyController->data_update();				
        $this->info("Reloadly OK");	
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' Reloadly OK' , FILE_APPEND);
        $this->info("Azione conclusa");
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' Providers updated' , FILE_APPEND);

    }
}