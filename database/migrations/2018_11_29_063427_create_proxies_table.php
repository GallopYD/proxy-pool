<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip', 15)->comment('IP地址');
            $table->string('port', 5)->comment('端口');
            $table->string('protocol', 8)->default('http')->comment('协议');
            $table->string('quality')->default('common')->comment('质量 common普通 stable稳定 premium优质');
            $table->string('anonymity')->default('transparent')->comment('匿名度 transparent透明 anonymous匿名 distorting混淆 high_anonymous高匿');
            $table->integer('speed')->default(0)->comment('响应速度 毫秒');
            $table->integer('succeed_times')->default(0)->comment('检测成功次数');
            $table->integer('fail_times')->default(0)->comment('连续失败次数');
            $table->timestamp('last_checked_at')->nullable()->comment('最后检测时间');
            $table->timestamp('last_used_at')->nullable()->comment('最后获取时间');
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
        Schema::dropIfExists('proxies');
    }
}
