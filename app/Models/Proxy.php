<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

/**
 * App\Models\Proxy
 *
 * @property int $id
 * @property string $ip IP地址
 * @property string $port 端口
 * @property string $protocol 协议
 * @property string $quality 质量 common普通 stable稳定 premium优质
 * @property string $anonymity 匿名度 transparent透明 anonymous匿名 distorting混淆 high_anonymous高匿
 * @property int $speed 响应速度 毫秒
 * @property int $used_times 使用次数
 * @property int $succeed_times 检测成功次数
 * @property int $fail_times 连续失败次数
 * @property string|null $last_checked_at 最后检测时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereFailTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereSucceedTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereUsedTimes($value)
 * @mixin \Eloquent
 */
class Proxy extends Model
{

    protected $guarded = [];

    static $redis_prefix = 'proxy:';

    const QUALITY_COMMON = 'common';//普通
    const QUALITY_STABLE = 'stable';//稳定
    const QUALITY_PREMIUM = 'premium';//优质

    const ANONYMITY_TRANSPARENT = 'transparent';//透明
    const ANONYMITY_DISTORTING = 'distorting';//混淆
    const ANONYMITY_ANONYMOUS = 'anonymous';//匿名
    const ANONYMITY_HIGH_ANONYMOUS = 'high_anonymous';//高匿

    /**
     * 获取最新验证代理
     * @param string $quality
     * @param null $anonymity
     * @return Model|null|object|static
     */
    public static function getNewest($quality = 'common', $anonymity = null)
    {
        if ($data = Redis::lpop(self::$redis_prefix . $quality)) {
            $data = json_decode($data);
            $proxy = Proxy::find($data->id);
        }
        if (!isset($proxy)) {
            $query = Proxy::query();
            if ($anonymity) {
                $query->whereAnonymity($anonymity);
            }
            $proxy = $query->whereQuality($quality)
                ->orderByDesc('last_checked_at')
                ->orderBy('used_times')
                ->first();
        }
        if ($proxy) {
            $proxy->used_times += 1;
            $proxy->update();
            return $proxy;
        }
        return null;
    }

    /**
     * 获取代理列表
     * @param array $condition
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList($quality)
    {
        $proxies = Proxy::whereQuality($quality)
            ->orderByDesc('last_checked_at')
            ->paginate(20);
        return $proxies;
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool|void
     * @throws \Exception
     */
    public function update(array $attributes = [], array $options = [])
    {
        //检测超过30次为稳定代理，100次为优质代理
        //检测失败次数自动剔除：普通代理1次，稳定代理3次，优质代理5次
        if ($this->quality == self::QUALITY_COMMON && $this->succeed_times >= 30) {
            $this->quality = self::QUALITY_STABLE;
            $this->save();
        } elseif ($this->quality == self::QUALITY_STABLE && $this->succeed_times >= 100) {
            $this->quality = self::QUALITY_PREMIUM;
            $this->save();
        } elseif ($this->quality == self::QUALITY_COMMON && $this->fail_times >= 1) {
            $this->delete();
        } elseif (in_array($this->quality, [self::QUALITY_STABLE, self::QUALITY_PREMIUM]) == self::QUALITY_STABLE && $this->fail_times >= 3) {
            $this->delete();
        } else {
            parent::update($attributes, $options);
        }
    }
}
