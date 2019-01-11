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
            'ip' => $this->ip,
            'port' => $this->port,
            'protocol' => $this->protocol,
            'quality' => $this->quality,
            'anonymity' => $this->anonymity,
            'speed' => $this->speed,
        ];
    }
}
