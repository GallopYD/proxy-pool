<?php

namespace App\Console\Commands;

use App\Models\Proxy;
use App\Spiders\Tester;
use Illuminate\Console\Command;

class ClearUsableProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:clear-usable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '可用代理清洗';

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
        Proxy::where('checked_times', '>', 0)
            ->orderBy('used_times')
            ->orderBy('updated_at')
            ->chunk(500, function ($proxies) use ($tester) {
                $proxies->each(function ($proxy) use ($tester) {
                    $tester->handle($proxy);
                });
            });
    }
}
