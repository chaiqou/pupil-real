<?php

namespace App\Http\Resources\Parent;

use Illuminate\Http\Resources\Json\JsonResource;

class LunchMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $menus = json_decode($this->menus, true);

        $menuItems = collect($menus)->flatMap(function ($menu, $date) {
            return collect($menu)->map(function ($item) use ($date) {
                return [
                    'date' => $date,
                    'name' => $item['name'],
                    'menu_type' => $item['menu_type'],
                ];
            });
        });

        return [
            'menus' => $menuItems->values(),
        ];
    }
}
