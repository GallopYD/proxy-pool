<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Proxy extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ip' => $this->ip,
            'port' => $this->port,
            'anonymity' => $this->anonymity,
            'protocol' => $this->protocol,
            'speed' => $this->speed,
            'used_times' => $this->used_times,
            'checked_times' => $this->checked_times,
            'last_checked_at' => $this->last_checked_at ? Carbon::parse($this->last_checked_at)->format('Y-m-d H:i:s') : '',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
