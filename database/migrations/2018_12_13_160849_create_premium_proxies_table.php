<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiumProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_proxies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip', 15)->comment('IP地址');
            $table->string('port', 5)->comment('端口');
            $table->string('anonymity')->default('transparent')->comment('匿名度 transparent透明 anonymous匿名 distorting混淆 high_anonymous高匿');
            $table->enum('protocol', ['http', 'https'])->comment('协议');
            $table->integer('speed')->default(0)->comment('响应速度 毫秒');
            $table->integer('used_times')->default(0)->comment('使用次数');
            $table->integer('checked_times')->default(0)->comment('检测次数');
            $table->integer('fail_times')->default(0)->comment('连续失败次数');
            $table->timestamp('last_checked_at')->nullable()->comment('最后检测时间');
            $table->timestamps();
            $table->unique(['ip', 'port', 'protocol']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premiun_proxies');
    }
}
