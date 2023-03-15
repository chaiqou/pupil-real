<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Helpers\CreateMenuJson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMenuRequest;
use App\Http\Requests\Parent\SaveMenuRequest;
use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Illuminate\Http\JsonResponse;

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

        if ($menu->wasRecentlyCreated) {
            return response()->json(['message' => 'Menu created']);
        } else {
            return response()->json(['message' => 'Menu on this day already exists']);
        }
    }

    public function saveMenu(SaveMenuRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $model = PeriodicLunch::where(function ($query) use ($validated) {
            $query->where('claims', 'like', '%"'.$validated['date'].'"%');
        })->first();

        // check if model exists and if so, update the JSON column
        if ($model) {
            $json = json_decode($model->claims, true);

            foreach ($json[$validated['date']] as &$element) {
                // set menu and menu_code values based on whether 'fixed' or 'choices' key exists
                if (is_array($validated['values']) && array_key_exists('choices', $validated['values'])) {
                    $element['menu'] = $validated['values']['choices'];
                    $element['menu_code'] = 2;
                } else {
                    $element['menu'] = $validated['values'];
                    $element['menu_code'] = 0;
                }
            }

            $model->claims = json_encode($json);
            $model->save();

            return response()->json('updated');
        } else {
            return response()->json('menu already saved');
        }
    }
}
