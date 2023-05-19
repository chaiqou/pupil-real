<?php

namespace App\Actions\Claims;

use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Carbon\Carbon;

class UpdateFixedMenuClaimAction
{
    public static function execute($validated, $menuId, $lunchId)
    {
        // This logic automatically updates claims json in PeriodicLunch if menu for day already exists and menu type is fixed
        $day = Carbon::parse($validated['day'])->addDay()->format('Y-m-d');
        $periodic_lunch = PeriodicLunch::where('claims', 'like', "%$day%")
            ->where('student_id', $validated['student_id'])
            ->first();

        if ($periodic_lunch) {
            $claims_array = json_decode($periodic_lunch->claims, true);

            if ($validated['menu_type'] === 'Fixed') {
                // Loop through each date in the $claims_array and check if it matches the "day" value in $validated
                foreach ($claims_array as $date => $claims) {
                    if ($date === $day) {
                        // Loop through each claim for that date and check if the "name" value matches the "menu_type" value in $validated.
                        foreach ($claims as $index => $claim) {
                            foreach ($validated['menus'] as $menu_key => $menu) {
                                if ($claim['name'] === $menu_key) {
                                    $claims_array[$date][$index]['menu'] = $menu;
                                    $claims_array[$date][$index]['menu_code'] = "{$menuId}-{$lunchId}-{$date}-{$claim['name']}-{$index}";
                                }
                            }
                        }
                    }
                }

                $periodic_lunch->claims = json_encode($claims_array);
                $periodic_lunch->save();
            }
        }
    }
}
