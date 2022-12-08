<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LunchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'merchant_id' => $this->merchant_id,
            'title' => $this->title,
            'description' => $this->description,
            'active_range' => $this->active_range,
            'available_days' => $this->available_days,
        ];
    }
}
