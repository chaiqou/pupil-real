<?php

namespace App\Http\Resources\School;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'short_name' => $this->short_name,
            'full_name' => $this->full_name,
            'long_name' => $this->long_name,
            'details' => json_decode($this->details),
            'school_code' => $this->school_code,
        ];
    }
}
