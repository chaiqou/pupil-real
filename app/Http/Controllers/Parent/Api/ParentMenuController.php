<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use App\Models\LunchMenu;
use App\Models\PeriodicLunch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParentMenuController extends Controller
{
    public function menuRetrieve(Request $request): JsonResponse
    {
        $studentId = request('student_id');

        $periodic_lunch = PeriodicLunch::where('student_id', $studentId)->get();
        $periodic_lunch_ids = $periodic_lunch->pluck('id')->toArray();
        $menu = LunchMenu::whereIn('lunch_id', $periodic_lunch_ids)->get();

        $choicesMenu = $menu->filter(function ($item) {
            $menus = json_decode($item->menus, true);
            foreach ($menus as $menuItems) {
                foreach ($menuItems as $menuItem) {
                    if (isset($menuItem['menu_type']) && $menuItem['menu_type'] === 'choices') {
                        return true;
                    }
                }
            }

            return false;
        });

        return response()->json(['choices_menu' =>  $choicesMenu, 'lunch' => $periodic_lunch]);
    }
}
