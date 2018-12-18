<?php

namespace App\Console\Commands;

use App\Models\Proxy;
use App\Spiders\Tester;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ProxyClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:clear {quality} {remainder?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '代理清洗';

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
        $remainder = $this->argument('remainder');
        $quality = $this->argument('quality');

        $tester = Tester::getInstance();
        $query = Proxy::whereQuality($quality);
        //普通代理分5个任务检测
        if ($quality == Proxy::QUALITY_COMMON) {
            $query->whereRaw("id % 5 = {$remainder}");
        }
        $proxies = $query->orderBy('last_checked_at')
            ->take(60)
            ->get();

        $proxies->each(function ($proxy) use ($tester) {
            $proxy_ip = $proxy->protocol . '://' . $proxy->ip . ':' . $proxy->port;
            if ($speed = $tester->handle($proxy_ip)) {
                $proxy->speed = $speed;
                $proxy->succeed_times = ++$proxy->succeed_times;
                $proxy->last_checked_at = Carbon::now();
                Redis::lpush(Proxy::$redis_prefix . $proxy->quality, json_encode($proxy));
            } else {
                $proxy->fail_times = ++$proxy->fail_times;
                $proxy->last_checked_at = Carbon::now();
            }
            $proxy->update();
        });
    }
}
