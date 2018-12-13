<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * App\Models\StableProxy
 *
 * @property int $id
 * @property string $ip IP地址
 * @property string $port 端口
 * @property string $anonymity 匿名度 transparent透明 anonymous匿名 distorting混淆 high_anonymous高匿
 * @property string $protocol 协议
 * @property int $speed 响应速度 毫秒
 * @property int $used_times 使用次数
 * @property int $checked_times 检测次数
 * @property string|null $last_checked_at 最后检测时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $fail_times 失败次数
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereCheckedTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereFailTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereUsedTimes($value)
 * @mixin \Eloquent
 */
class StableProxy extends Proxy
{
    protected $guarded = [];
    static $redis_key = 'proxy:stable';

    public function update(array $attributes = [], array $options = [])
    {
        //检查超过100次归为优质代理
        if ($this->checked_times >= 100) {
            $proxy = $this->toArray();
            unset($proxy['id']);
            unset($proxy['fail_times']);
            $proxy['last_checked_at'] = Carbon::now();
            PremiumProxy::insert($proxy);
            $this->delete();
        } elseif ($this->fail_times > 3) {
            //稳定代理连续失败3次，自动剔除
            $this->delete();
        } else {
            parent::update($attributes, $options);
        }
    }
}
