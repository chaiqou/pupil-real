<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class NavigationController extends Controller
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
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => 'dashboard', 'current' => false],
                    ['name' => 'Lunch management', 'icon' => 'BuildingOffice2Icon', 'href' => 'lunch-management', 'current' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' => 'transactions', 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => 'students', 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => 'knowledge-base', 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => 'settings', 'current' => false],
                ];
            $role = 'school';
        }
        if($user->hasRole('parent'))
        {
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => 'dashboard', 'current' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' => 'transactions', 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => 'students', 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => 'knowledge-base', 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => 'settings', 'current' => false],
                ];
            $role = 'parent';
        }

        $currentTab = request()->route()->getName();


        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
        ])->with(['page', 'Dashboard']);
	}
}
