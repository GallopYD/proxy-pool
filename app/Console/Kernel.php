<?php

namespace App\Console;

use App\Console\Commands\ProxyCrawl;
use App\Console\Commands\ProxyClear;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ProxyCrawl::class,
        ProxyClear::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //代理爬取
        $schedule->command('proxy:crawl')->everyFiveMinutes();
        //代理清洗
        $schedule->command('proxy:clear 0')->everyFiveMinutes();
        $schedule->command('proxy:clear 1')->everyFiveMinutes();
        $schedule->command('proxy:clear 2')->everyFiveMinutes();
        $schedule->command('proxy:clear 3')->everyFiveMinutes();
        $schedule->command('proxy:clear 4')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
