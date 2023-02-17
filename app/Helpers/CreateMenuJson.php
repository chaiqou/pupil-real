<?php

namespace App\Helpers;

use Carbon\Carbon;

class CreateMenuJson
{
    private $validate;

    public function __construct($validate)
    {
        $this->validate = $validate;
    }

    public function calculateMenu()
    {
        // We are creating array each of array includes name menu_type and menus (user input)
        $menus = collect($this->validate['menus'])->map(function ($menu, $name) {
            $menuType = ($this->validate['menu_type'] === 'Choices') ? 'choices' : 'fixed';

            return [
                'name' => $name,
                'menu_type' => $menuType,
                'menus' => $menu,
            ];
        });

        // Group the menus by date

        $result = $menus->groupBy(function () {
            return Carbon::parse($this->validate['day'])->format('Y-m-d 23:00:00');
        })->toArray();

        return $result;
    }
}
