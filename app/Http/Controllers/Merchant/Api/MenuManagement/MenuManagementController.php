<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Helpers\CreateMenuJson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMenuRequest;
use App\Http\Requests\Parent\ChoiceMenuClaimsRequest;
use App\Jobs\UpdateFixedMenuClaims;
use App\Models\LunchMenu;
use App\Models\PeriodicLunch;

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

        // This updates fixed menu claims when we are creating menu

        UpdateFixedMenuClaims::dispatch($validated);

        return response()->json('Menu Created');
    }

    public function updateChoiceMenuClaims(ChoiceMenuClaimsRequest $request)
    {
        $validated = $request->validated();
        $periodic_lunch = PeriodicLunch::where('claims', 'like', "%$validated[date]%")->first();

        $claims_array = json_decode($periodic_lunch->claims, true);

        //  loop through each date in the $claims_array and checks if it matches the "date" value in $validated
        foreach ($claims_array as $date => $claims) {
            if ($date === $validated['date']) {
                // loop through each claim for that date and checks if the "name" value matches the "claimable_type" value in $validated.
                foreach ($claims as $index => $claim) {
                    if ($claim['name'] === $validated['claimable_type'] && $claim['menu'] === '') {
                        $claims_array[$date][$index]['menu'] = $validated['claimable'];
                        $claims_array[$date][$index]['menu_code'] = 2;
                    }
                }
            }
        }

        $periodic_lunch->claims = json_encode($claims_array);
        $periodic_lunch->save();

        return response()->json('Claims for choices updated');
    }
}
