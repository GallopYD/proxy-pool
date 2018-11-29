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
            $table->string('anonymity')->default('transparent')->comment('匿名度 transparent透明 anonymous匿名');
            $table->enum('protocol', ['http', 'https'])->comment('协议');
            $table->integer('speed')->default(0)->comment('响应速度 毫秒');
            $table->timestamp('checked_at')->nullable()->comment('最新校验时间');
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
