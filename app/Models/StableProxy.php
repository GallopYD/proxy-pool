<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereCheckedTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StableProxy whereCreatedAt($value)
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
class StableProxy extends Model
{
    protected $guarded = [];

    const ANONYMITY_TRANSPARENT = 'transparent';//透明
    const ANONYMITY_DISTORTING = 'distorting';//混淆
    const ANONYMITY_ANONYMOUS = 'anonymous';//匿名
    const ANONYMITY_HIGH_ANONYMOUS = 'high_anonymous';//高匿

    /**
     * 获取最新验证代理
     * @param null $anonymity
     * @return Model|null|object|static
     */
    public static function getNewest($anonymity = null)
    {
        $query = self::query();
        if ($anonymity) {
            $query->whereAnonymity($anonymity);
        }
        $time = Carbon::now()->subMinutes(3);//3分钟内检测过
        $proxy = $query->where('last_checked_at', '>', $time)
            ->orderBy('used_times')
            ->orderByDesc('checked_times')
            ->first();
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
    public static function getList($condition = [])
    {
        $query = self::query();
        if (isset($condition['anonymity'])) {
            $query->whereAnonymity($condition['anonymity']);
        }
        $query->orderByDesc('last_checked_at')
            ->orderByDesc('checked_times')
            ->orderBy('used_times')
            ->orderBy('speed');
        if (isset($condition['per_page'])) {
            $proxies = $query->paginate($condition['per_page']);
        } else {
            $proxies = $query->paginate(20);
        }
        return $proxies;
    }
}
