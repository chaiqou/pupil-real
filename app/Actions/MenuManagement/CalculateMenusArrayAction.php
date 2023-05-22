<?php

namespace App\Actions\MenuManagement;

use Carbon\Carbon;

class CalculateMenusArrayAction
{
    public static function execute(array $validate): array
    {
        // We are creating array each of array includes name menu_type and menus (user input)
        $menus = collect($validate['menus'])->map(function ($menu, $name) use ($validate) {
            $menuType = ($validate['menu_type'] === 'Choices') ? 'choices' : 'fixed';

            return [
                'name' => $name,
                'menu_type' => $menuType,
                'menus' => $menu,
            ];
        });

        // Group the menus by date

        $result = $menus->groupBy(function () use ($validate) {
            return Carbon::parse($validate['day'])->addDay()->format('Y-m-d');
        })->toArray();

        return $result;
    }
}
