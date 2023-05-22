<?php

namespace App\Actions\Claims;

use App\Models\PeriodicLunch;
use Carbon\Carbon;

class UpdateFixedMenuClaimAction
{
    public static function execute($validated, $menuId, $lunchId)
    {
        // This logic automatically updates claims json in PeriodicLunch if menu for day already exists and menu type is fixed
        $day = Carbon::parse($validated['day'])->addDay()->format('Y-m-d');
        $periodicLunch = PeriodicLunch::where('claims', 'like', "%$day%")->first();

        if ($periodicLunch) {
            $claimsArray = json_decode($periodicLunch->claims, true);

            if ($validated['menu_type'] === 'Fixed') {
                // Loop through each date in the $claimsArray and check if it matches the "day" value in $validated
                foreach ($claimsArray as $date => $claims) {
                    if ($date === $day) {
                        // Loop through each claim for that date and check if the "name" value matches the "menu_type" value in $validated.
                        foreach ($claims as $index => $claim) {
                            foreach ($validated['menus'] as $menuKey => $menu) {
                                if ($claim['name'] === $menuKey) {
                                    $claimsArray[$date][$index]['menu'] = $menu;
                                    $claimsArray[$date][$index]['menu_code'] = "{$menuId}-{$lunchId}-{$date}-{$claim['name']}-{$index}";
                                }
                            }
                        }
                    }
                }

                $periodicLunch->claims = json_encode($claimsArray);
                $periodicLunch->save();
            }
        }
    }
}
