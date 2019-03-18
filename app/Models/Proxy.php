<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
 * @property int $succeed_times 检测成功次数
 * @property int $fail_times 连续失败次数
 * @property string|null $last_checked_at 最后检测时间
 * @property string|null $last_used_at 最后获取时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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

    const QUALITY_COMMON = 'common';//普通
    const QUALITY_STABLE = 'stable';//稳定
    const QUALITY_PREMIUM = 'premium';//优质

    const ANONYMITY_TRANSPARENT = 'transparent';//透明
    const ANONYMITY_DISTORTING = 'distorting';//混淆
    const ANONYMITY_ANONYMOUS = 'anonymous';//匿名
    const ANONYMITY_HIGH_ANONYMOUS = 'high_anonymous';//高匿

    /**
     * 获取最新验证代理
     * @param Request $request
     * @return Model|null|object|static
     */
    public static function getNewest(Request $request)
    {
        $quality = $request->quality ? $request->quality : self::QUALITY_PREMIUM;
        $query = Proxy::query();
        if ($request->anonymity) {
            $query->whereAnonymity($request->anonymity);
        }
        if ($request->protocol) {
            $query->whereProtocol($request->protocol);
        }
        //10分钟内检测过
        $time_interval = Carbon::now()->subMinutes(10);
        $proxy = $query->whereQuality($quality)
            ->where('last_checked_at', '>', $time_interval)
            ->whereFailTimes(0)
            ->orderBy('last_used_at')
            ->first();
        if ($proxy) {
            $proxy->last_used_at = Carbon::now();
            $proxy->update();
        }
        return $proxy;
    }

    /**
     * 获取代理列表
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 20;
        $quality = $request->quality ? $request->quality : self::QUALITY_PREMIUM;
        $query = Proxy::whereQuality($quality);
        if ($request->anonymity) {
            $query->whereAnonymity($request->anonymity);
        }
        if ($request->protocol) {
            $query->whereProtocol($request->protocol);
        }
        $proxies = $query->whereNotNull('last_checked_at')
            ->orderByDesc('last_checked_at')
            ->paginate($per_page);
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
        //检测成功超过20次为稳定代理，50次为优质代理
        //检测失败次数自动剔除：普通代理1次，稳定代理5次，优质代理10次
        if ($this->quality == self::QUALITY_COMMON && $this->succeed_times >= 20) {
            $this->quality = self::QUALITY_STABLE;
            $this->save();
        } elseif ($this->quality == self::QUALITY_STABLE && $this->succeed_times >= 50) {
            $this->quality = self::QUALITY_PREMIUM;
            $this->save();
        } elseif ($this->quality == self::QUALITY_COMMON && $this->fail_times >= 1) {
            $this->delete();
        } elseif ($this->quality == self::QUALITY_STABLE && $this->fail_times >= 5) {
            $this->delete();
        } elseif ($this->quality == self::QUALITY_PREMIUM && $this->fail_times >= 10) {
            $this->delete();
        } else {
            parent::update($attributes, $options);
        }
    }
}
