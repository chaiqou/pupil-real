<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMenuRequest;
use Carbon\Carbon;

class MenuManagementController extends Controller
{
    public function createMenu(CreateMenuRequest $request)
    {
        $validated = $request->validated();

        // We are creating array each of array includes name menu_type and menus (user input)
        $menus = collect($validated['menus'])->map(function ($menu, $name) use ($validated) {
            $menuType = ($validated['menu_type'] === 'Choices') ? 'choices' : 'fixed';

            return [
                'name' => $name,
                'menu_type' => $menuType,
                'menus' => $menu,
            ];
        });

        // Group the menus by date

        $result = $menus->groupBy(function () use ($validated) {
            return Carbon::parse($validated['day'])->format('Y-m-d 23:00:00');
        })->toArray();

        dd($result);
    }
}
