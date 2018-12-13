<?php

namespace App\Console\Commands;

use App\Models\PremiumProxy;
use App\Spiders\Tester;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class PremiumProxyClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'premium-proxy:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '优质代理清洗';

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
        $proxies = PremiumProxy::query()
            ->orderBy('last_checked_at')
            ->take(20)
            ->get();
        $redis_key = PremiumProxy::$redis_key;
        $proxies->each(function ($proxy) use ($tester, $redis_key) {
            $proxy_ip = $proxy->protocol . '://' . $proxy->ip . ':' . $proxy->port;
            if ($speed = $tester->handle($proxy_ip)) {
                $proxy->update([
                    'speed' => $speed,
                    'checked_times' => ++$proxy->checked_times,
                    'last_checked_at' => Carbon::now(),
                ]);
                if (Redis::llen($redis_key) > 1000) {
                    Redis::ltrim($redis_key, 1, 500);
                }
                Redis::lpush($redis_key, json_encode($proxy));
            } else {
                $proxy->update([
                    'fail_times' => ++$proxy->fail_times,
                ]);
            }
        });
    }
}
