<?php

namespace App\Models;

/**
 * App\Models\PremiumProxy
 *
 * @property int $id
 * @property string $ip IP地址
 * @property string $port 端口
 * @property string $anonymity 匿名度 transparent透明 anonymous匿名 distorting混淆 high_anonymous高匿
 * @property string $protocol 协议
 * @property int $speed 响应速度 毫秒
 * @property int $used_times 使用次数
 * @property int $checked_times 检测次数
 * @property int $fail_times 失败次数
 * @property string|null $last_checked_at 最后检测时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereCheckedTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereFailTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PremiumProxy whereUsedTimes($value)
 * @mixin \Eloquent
 */
class PremiumProxy extends Proxy
{
    protected $guarded = [];
    static $redis_key = 'proxy:premium';

    public function update(array $attributes = [], array $options = [])
    {
        //优质代理连续失败5次，自动剔除
        if ($this->fail_times > 5) {
            $this->delete();
        } else {
            parent::update($attributes, $options);
        }
    }
}
