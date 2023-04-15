<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Exports\WeeklyOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Lunch;
use App\Models\PeriodicLunch;
use App\Services\ExcelService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MenuExportController extends Controller
{
    protected $excelService;

    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    public function exportMenu(Request $request)
    {
        $dayAndWeekJson = $request->query('dayAndWeek');
        $dayAndWeek = json_decode($dayAndWeekJson);

        $excelService = new ExcelService();
        $result = $excelService->findLunchesForExcelFile($dayAndWeek[0]->week);

        // Get the weekdays and filteredLunches
        $weekDays = $result['weekDays'];
        $lunches = $result['filteredLunches'];

        // convert array to collection
        $lunchesCollection = collect($lunches);

        // eager load menus for each lunch
        $lunchesWithMenus = Lunch::with('menus')->whereIn('id', $lunchesCollection->pluck('id'))->get();

        foreach ($lunchesWithMenus as $lunchWithMenuKey => $lunchWithMenu) {
            foreach ($lunchWithMenu->menus as $menuKey => $wholeMenu) {
                // Each menu array's nested "Menus" json
                $menuArray = json_decode($wholeMenu->menus, true);

                foreach ($menuArray as $date => &$menus) {
                    // Get each menu separately
                    foreach ($menus as $index => &$menu) {
                        // if menu type is choices
                        if (is_array($menu['menus'])) {
                            foreach ($menu['menus'] as $subIndex => &$subMenu) {
                                $choicesMenuKey = "{$wholeMenu['id']}-{$wholeMenu['lunch_id']}-{$date}-{$subMenu}-{$subIndex}";
                                $menuCount = PeriodicLunch::where('claims', 'LIKE', '%'.$choicesMenuKey.'%')->count();
                                $subMenu = [
                                    'menus' => $subMenu,
                                    'menu_count' => $menuCount,
                                ]; // Add menu_count key with value to subMenu
                            }
                        } else {
                            $fixedMenuKey = "{$wholeMenu['id']}-{$wholeMenu['lunch_id']}-{$date}-{$menu['name']}-{$index}";
                            $menuCount = PeriodicLunch::where('claims', 'LIKE', '%'.$fixedMenuKey.'%')->count();
                            $menu['menu_count'] = $menuCount; // Add menu_count key with value to menu
                        }
                    }
                }

                // Update the original "Menus" json with the modified array
                $wholeMenu->menus = json_encode($menuArray);
            }
        }

        foreach ($lunches as $lunch) {
            if ($lunch->menus->count() == 0) {
                return Excel::download(new WeeklyOrdersExport($weekDays, $lunches), 'weekly_orders.xlsx');
            } else {
                return Excel::download(new WeeklyOrdersExport($weekDays, $lunchesWithMenus), 'weekly_orders.xlsx');
            }
        }
    }
}
