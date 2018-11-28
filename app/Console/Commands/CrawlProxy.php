<?php

namespace App\Console\Commands;

use App\Spiders\Spider;
use Illuminate\Console\Command;

class CrawlProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:crawl {drivers?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl Proxy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$drivers = $this->argument('drivers')) {
            $drivers = config('proxy.drivers');
        }
        $drivers = explode('|', $drivers);
        foreach ($drivers as $driver) {
            $spider = Spider::getInstance();
            $spider->setDriver($driver);
            $spider->handle();
        }
    }
}
