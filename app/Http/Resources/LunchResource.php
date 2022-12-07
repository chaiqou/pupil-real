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
            'period_length' => $this->period_length,
            'holds' => $this->holds,
            'extras' => $this->extras,
            'weekdays' => $this->weekdays,
            'price_day' => $this->price_day,
            'price_period' => $this->price_period,
        ];
    }
}
