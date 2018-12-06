<?php

namespace App\Console\Commands;

use App\Models\StableProxy;
use App\Spiders\Tester;
use Illuminate\Console\Command;

class StableProxyClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stable-proxy:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '稳定代理清洗';

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
        $tester = Tester::getInstance();
        $proxies = StableProxy::query()
            ->orderBy('last_checked_at')
            ->take(20)
            ->get();
        $proxies->each(function ($proxy) use ($tester) {
            $tester->handle($proxy);
        });
    }
}
