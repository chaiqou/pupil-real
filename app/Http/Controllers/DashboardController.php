<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
	public function index(): View
	{
        $navigation = [];
        $role = '';
        $user = auth()->user();
        if($user->hasRole('admin'))
        {
            $navigation =
                [
                    ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '#', 'current' => true],
                ];
            $role = 'admin';
        }
        if($user->hasRole('school'))
        {
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => 'dashboard', 'current' => true],
                    ['name' => 'Team', 'icon' => 'UsersIcon', 'href' => 'team', 'current' => false],
                    ['name' => 'Projects', 'icon' => 'FolderIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Calendar', 'icon' => 'CalendarIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Documents', 'icon' => 'InboxIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Reports', 'icon' => 'ChartBarIcon', 'href' => '#', 'current' => false],
                ];
            $role = 'school';
        }
        if($user->hasRole('parent'))
        {
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => '#', 'current' => true],
                    ['name' => 'Team', 'icon' => 'UsersIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Projects', 'icon' => 'FolderIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Calendar', 'icon' => 'CalendarIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Documents', 'icon' => 'InboxIcon', 'href' => '#', 'current' => false],
                    ['name' => 'Reports', 'icon' => 'ChartBarIcon', 'href' => '#', 'current' => false],
                ];
            $role = 'parent';
        }
		return view('dashboard', [
            'navigation' => $navigation,
            'role' => $role,
        ])->with('page', 'Dashboard');
	}
}
