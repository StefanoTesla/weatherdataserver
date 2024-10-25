<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WeatherSyncCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weather-sync-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if we got data in the latest 15mins.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
