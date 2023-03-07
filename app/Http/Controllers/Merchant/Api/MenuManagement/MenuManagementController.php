<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Helpers\CreateMenuJson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMenuRequest;
use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Illuminate\Http\Request;

class MenuManagementController extends Controller
{
    public function createMenu(CreateMenuRequest $request)
    {
        $validated = $request->validated();
        $createMenuInstance = new CreateMenuJson($validated);
        $createdMenuJson = $createMenuInstance->calculateMenu();

        // If a Menu with the same date and lunch_id already exists in the database, model will not be created
        $menu = LunchMenu::firstOrCreate([
            'date' => array_keys($createdMenuJson)[0],
            'lunch_id' => $validated['lunch_id'],
        ], [
            // This array contains the default values to use when creating a new Menu
            'menus' => json_encode($createdMenuJson),
        ]);

        if ($menu) {
            return response()->json(['error' => 'Menu for this lunch already exists']);
        }
    }

    public function saveMenu(Request $request)
    {
        $model = PeriodicLunch::where(function ($query) {
            $query->where('claims', 'like', '%"'.request('date').'"%');
        })->first();

        // check if model exists and if so, update the JSON column
        if ($model) {
            $json = json_decode($model->claims, true);

            foreach ($json[request('date')] as &$element) {
                $element['menu'] = request('values.fixed') ?? request('values.choices');
                $element['menu_code'] = request('values.fixed') ? 0 : 2;
            }

            $model->claims = json_encode($json);
            $model->save();

            return response()->json('updated');
        }
    }
}
