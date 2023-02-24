<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Helpers\CreateMenuJson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMenuRequest;
use App\Models\LunchMenu;

class MenuManagementController extends Controller
{
    public function createMenu(CreateMenuRequest $request)
    {
        $validated = $request->validated();
        $createMenuInstance = new CreateMenuJson($validated);
        $createdMenuJson = $createMenuInstance->calculateMenu();

        $menu = LunchMenu::firstOrCreate([
            'date' => array_keys($createdMenuJson)[0],
            'lunch_id' => $validated['lunch_id'],
        ], [
            // This array contains the default values to use when creating a new Menu
            // If a Menu with the same date and lunch_id already exists in the database, these values will not be used
            'menus' => json_encode($createdMenuJson),
            'date' => array_keys($createdMenuJson)[0],
            'lunch_id' => $validated['lunch_id'],
        ]);

        if ($menu) {
            return response()->json(['error' => 'Menu for this lunch already exists']);
        }
    }
}
