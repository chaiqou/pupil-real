<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
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
            'merchant_nick' => $this->merchant_nick,
            'company_legal_name' => $this->company_legal_name,
            'activated' => $this->activated,
            'user_id' => $this->user_id,
            'school_id' => $this->school_id,
            'billingo_api_key' => $this->billingo_api_key,
            'has_balance' => $this->has_balance,
            'has_lunch' => $this->has_lunch,
            'company_details' => json_decode($this->company_details),
            'private_key' => $this->private_key,
            'public_key' => $this->public_key,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
