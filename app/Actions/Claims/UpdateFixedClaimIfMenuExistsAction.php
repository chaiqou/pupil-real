<?php

namespace App\Actions\Claims;

use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Carbon\Carbon;

class UpdateFixedClaimIfMenuExistsAction
{
    public static function execute(array $validated)
    {
        // This logic automatically updates claims json in PeriodicLunch if menu for day already exists and menu type is fixed

        foreach ($validated['claim_days'] as $date) {
            $day = Carbon::parse($date)->addDay()->format('Y-m-d');
            $lunchMenu = LunchMenu::where('date', $day)->first();
            $periodicLunch = PeriodicLunch::where('claims', 'like', "%$day%")
                ->where('student_id', $validated['student_id'])
                ->first();

            if ($lunchMenu && $periodicLunch) {
                $claimsArray = json_decode($periodicLunch->claims, true);
                $menusArray = json_decode($lunchMenu['menus'], true);

                if ($menusArray[$day][0]['menu_type'] === 'fixed') {
                    // Loop through each date in the $claimsArray and check if it matches the "day" value in $validated
                    foreach ($claimsArray as $date => $claims) {
                        if ($date === $day) {
                            // Loop through each claim for that date and check if the "name" value matches the "menu_type" value in $this->validated.
                            foreach ($claims as $index => $claim) {
                                foreach ($menusArray as $menu_key => $menu) {
                                    foreach ($menu as $menu_name) {
                                        if ($claim['name'] === $menu_name['name']) {
                                            $claimsArray[$date][$index]['menu'] = $menu_name['menus'];
                                            $claimsArray[$date][$index]['menu_code'] = "{$lunchMenu['id']}-{$lunchMenu['lunch_id']}-{$date}-{$claim['name']}-{$index}";
                                        }
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
}
