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
        $schedule->command('proxy:crawl Data5u')->everyTenMinutes();
        $schedule->command('proxy:crawl Ip3366')->everyTenMinutes();
        $schedule->command('proxy:crawl Kuaidaili')->everyTenMinutes();
        $schedule->command('proxy:crawl Xicidaili')->everyTenMinutes();
        $schedule->command('proxy:crawl Fatezero')->hourly();

        //代理清洗
        $schedule->command('proxy:clear common 0')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 1')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 2')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 3')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 4')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 5')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 6')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 7')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 8')->cron('*/2 * * * *');
        $schedule->command('proxy:clear common 9')->cron('*/2 * * * *');

        //稳定代理清洗
        $schedule->command('proxy:clear stable 0')->cron('*/2 * * * *');
        $schedule->command('proxy:clear stable 1')->cron('*/2 * * * *');
        $schedule->command('proxy:clear stable 2')->cron('*/2 * * * *');

        //优质代理清洗
        $schedule->command('proxy:clear premium 0')->cron('*/2 * * * *');
        $schedule->command('proxy:clear premium 1')->cron('*/2 * * * *');
        $schedule->command('proxy:clear premium 2')->cron('*/2 * * * *');
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
