<?php

namespace App\Console\Commands;

use App\Models\Proxy;
use App\Spiders\Tester;
use Illuminate\Console\Command;

class TestProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing Proxy';

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
        //每次检测数量
        $count = config('proxy.test_count');

        $tester = Tester::getInstance();
        $proxies = Proxy::query()->orderBy('updated_at')
            ->limit($count)
            ->get();
        $proxies->each(function ($proxy) use ($tester) {
            $tester->handle($proxy);
        });
    }
}
