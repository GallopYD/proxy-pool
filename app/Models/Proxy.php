<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Proxy
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereCheckedTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereLastCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereProtocol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Proxy whereUsedTimes($value)
 * @mixin \Eloquent
 */
class Proxy extends Model
{

    protected $guarded = [];

    const ANONYMITY_TRANSPARENT = 'transparent';//透明
    const ANONYMITY_ANONYMOUS = 'anonymous';//匿名

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
        $proxy = $query->where('checked_times', '>', '1')
            ->orderBy('used_times')
            ->orderByDesc('checked_times')
            ->orderByDesc('last_checked_at')
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
        $query->orderBy('used_times')
            ->orderByDesc('checked_times')
            ->orderBy('speed')
            ->orderByDesc('last_checked_at');
        if (isset($condition['per_page'])) {
            $proxies = $query->paginate($condition['per_page']);
        } else {
            $proxies = $query->paginate(20);
        }
        return $proxies;
    }
}
