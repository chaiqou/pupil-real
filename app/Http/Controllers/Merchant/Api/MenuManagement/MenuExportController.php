<?php

namespace App\Http\Controllers\Merchant\Api\MenuManagement;

use App\Models\Lunch;
use Illuminate\Http\Request;
use App\Models\PeriodicLunch;
use App\Services\ExcelService;
use App\Exports\LunchOrdersExport;
use App\Exports\WeeklyOrdersExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklyOrderSheetsExport;

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

        // Calculate menu_key as it is in periodic_lunch , based on this i have to count orders
        foreach ($lunchesWithMenus  as $lunch) {
            foreach ($lunch->menus as $lunchMenu) {
                $menusArray = json_decode($lunchMenu->menus, true);

                foreach ($menusArray as $date => &$menuItems) {
                    foreach ($menuItems as $index => &$menuItem) {
                        $menuKey = "{$lunchMenu['id']}-{$lunch['id']}-{$date}-{$menuItem['name']}-{$index}";
                        $menuCount = PeriodicLunch::where('claims', 'LIKE', '%'.$menuKey.'%')->count();
                        $menuItem['menu_count'] = $menuCount; // add menu_count for each lunch option
                    }
                }

                $lunchMenu->menus = json_encode($menusArray); // update the modified menus back to the database
            }
        }

        // Total orders for each lunch

        $totalOrders = [];
        foreach ($lunches as $lunch) {
            $totalOrders[$lunch->id] = $lunch->periodicLunches->count();
        }

        // foreach ($lunches as $lunch) {
        //     if ($lunch->menus->count() == 0) {
        //         return Excel::download(new LunchOrdersExport($lunches, $totalOrders), 'lunches_total.xlsx');
        //     } else {
        //         return Excel::download(new LunchOrdersExport($lunchesWithMenus, $totalOrders), 'lunches_total.xlsx');
        //     }
        // }

        return Excel::download(new WeeklyOrdersExport($weekDays), 'weekly_orders.xlsx');
    }
}
