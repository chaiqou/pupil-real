<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
	public function index(): View
	{
        $user = auth()->user();
        $navigation = [];
        if($user->hasRole('admin'))
        {
            $navigation =
                [
                   ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '#', 'current' => true],
                ];
        }
        if($user->hasRole('school') || $user->hasRole('parent'))
        {
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => '#'],
                    ['name' => 'Team', 'icon' => 'UsersIcon', 'href' => '#'],
                    ['name' => 'Projects', 'icon' => 'FolderIcon', 'href' => '#'],
                    ['name' => 'Calendar', 'icon' => 'CalendarIcon', 'href' => '#'],
                    ['name' => 'Documents', 'icon' => 'InboxIcon', 'href' => '#'],
                    ['name' => 'Reports', 'icon' => 'ChartBarIcon', 'href' => '#'],
                ];
        }
		return view('dashboard', [
            'navigation' => $navigation
        ])->with('page', 'Dashboard');
	}
}
