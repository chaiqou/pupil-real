<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Actions\Excel\FindExcelLunchesAction;
use App\Exports\WeeklyOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Lunch;
use App\Models\PeriodicLunch;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TotalOrdersExcelController extends Controller
{
    public function totalOrdersExcel(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $daysAndWeeksJson = $request->query('dayAndWeek');
        $daysAndWeeksArray = json_decode($daysAndWeeksJson);

        $weekNumber = $daysAndWeeksArray[0]->week;


        $lunches = FindExcelLunchesAction::execute($weekNumber);

        $weekDays = array_map(fn($item) => $item->date, $daysAndWeeksArray);
        $filteredLunches = $lunches['filteredLunches'];

        $lunchesWithMenus = Lunch::with('menus')
            ->whereIn('id', collect($filteredLunches)->pluck('id'))
            ->get();

        $this->updateMenusWithCounts($lunchesWithMenus);

        $lunchesToExport = collect($lunches)->count() === 0 ? $lunches : $lunchesWithMenus;

        return Excel::download(new WeeklyOrdersExport($weekDays, $lunchesToExport), 'weekly_orders.xlsx');
    }

    private function updateMenusWithCounts($lunchesWithMenus)
    {
        foreach ($lunchesWithMenus as $lunchWithMenu) {
            foreach ($lunchWithMenu->menus as $wholeMenu) {
                $menuArray = json_decode($wholeMenu->menus, true);

                foreach ($menuArray as $date => &$menus) {
                    foreach ($menus as $index => &$menu) {
                        if (is_array($menu['menus'])) {
                            foreach ($menu['menus'] as $subIndex => &$subMenu) {
                                $choicesMenuKey = "{$wholeMenu->id}-{$wholeMenu->lunch_id}-{$date}-{$subMenu}-{$subIndex}";
                                $menuCount = PeriodicLunch::where('claims', 'LIKE', '%' . $choicesMenuKey . '%')->count();
                                $subMenu = [
                                    'menus' => $subMenu,
                                    'menu_count' => $menuCount,
                                ];
                            }
                        } else {
                            $fixedMenuKey = "{$wholeMenu->id}-{$wholeMenu->lunch_id}-{$date}-{$menu['name']}-{$index}";
                            $menuCount = PeriodicLunch::where('claims', 'LIKE', '%' . $fixedMenuKey . '%')->count();
                            $menu['menu_count'] = $menuCount;
                        }
                    }
                }

                $wholeMenu->menus = json_encode($menuArray);
            }
        }
    }
}
