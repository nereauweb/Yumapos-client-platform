<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestCron'; // Nota deve essere uguale al command impostato sul Kernel

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TestCron';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //Azione da eseguire qui ad esempio update database etc

        //success stampato in console
        $this->info("Test cron cmd ok");		
		file_put_contents(base_path('storage/app/cron.log'), PHP_EOL . date("d/m/Y H:i") . ' Test cron OK' , FILE_APPEND);

    }
}