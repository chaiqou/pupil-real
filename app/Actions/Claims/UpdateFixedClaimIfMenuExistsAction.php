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
        $lunch_menu = LunchMenu::where('date', $day)->first();
        $periodic_lunch = PeriodicLunch::where('claims', 'like', "%$day%")
        ->where('student_id', $validated['student_id'])
        ->first();

        if ($lunch_menu && $periodic_lunch) {
            $claims_array = json_decode($periodic_lunch->claims, true);
            $menus_array = json_decode($lunch_menu['menus'], true);

            if ($menus_array[$day][0]['menu_type'] === 'fixed') {
                // Loop through each date in the $claims_array and check if it matches the "day" value in $validated
                foreach ($claims_array as $date => $claims) {
                    if ($date === $day) {
                        // Loop through each claim for that date and check if the "name" value matches the "menu_type" value in $this->validated.
                        foreach ($claims as $index => $claim) {
                            foreach ($menus_array as $menu_key => $menu) {
                                foreach ($menu as $menu_name) {
                                    if ($claim['name'] === $menu_name['name']) {
                                        $claims_array[$date][$index]['menu'] = $menu_name['menus'];
                                        $claims_array[$date][$index]['menu_code'] = "{$lunch_menu['id']}-{$lunch_menu['lunch_id']}-{$date}-{$claim['name']}-{$index}";
                                    }
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
}
