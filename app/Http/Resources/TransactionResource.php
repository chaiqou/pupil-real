<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
          'transaction_type' => $this->transaction_type,
          'amount' => $this->amount,
          'transaction_date' => $this->transaction_date,
          'merchant' => $this->merchant,
          'student'  =>  $this->student,
        ];
    }
}
