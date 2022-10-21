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
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => 'dashboard', 'current' => false],
                    ['name' => 'Team', 'icon' => 'UsersIcon', 'href' => 'team', 'current' => false],
                    ['name' => 'Projects', 'icon' => 'FolderIcon', 'href' => 'projects', 'current' => false],
                    ['name' => 'Calendar', 'icon' => 'CalendarIcon', 'href' => 'calendar', 'current' => false],
                    ['name' => 'Documents', 'icon' => 'InboxIcon', 'href' => 'documents', 'current' => false],
                    ['name' => 'Reports', 'icon' => 'ChartBarIcon', 'href' => 'reports', 'current' => false],
                ];
            $role = 'school';
        }
        if($user->hasRole('parent'))
        {
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => 'dashboard', 'current' => false],
                    ['name' => 'Team', 'icon' => 'UsersIcon', 'href' => 'team', 'current' => false],
                    ['name' => 'Projects', 'icon' => 'FolderIcon', 'href' => 'projects', 'current' => false],
                    ['name' => 'Calendar', 'icon' => 'CalendarIcon', 'href' => 'calendar', 'current' => false],
                    ['name' => 'Documents', 'icon' => 'InboxIcon', 'href' => 'documents', 'current' => false],
                    ['name' => 'Reports', 'icon' => 'ChartBarIcon', 'href' => 'reports', 'current' => false],
                ];
            $role = 'parent';
        }

        $currentTab = request()->route()->getName();

        if($currentTab === 'team')
        {
            return view('team', [
                'current' => $currentTab,
                'navigation' => $navigation,
                'role' => $role
                ])->with(['page', 'Dashboard']);
        }

        if($currentTab === 'projects')
        {
            return view('projects', [
                'current' => $currentTab,
                'navigation' => $navigation,
                'role' => $role
            ]);
        }

        if($currentTab === 'calendar')
        {
            return view('calendar', [
                'current' => $currentTab,
                'navigation' => $navigation,
                'role' => $role
            ]);
        }

        if($currentTab === 'documents')
        {
            return view('documents', [
                'current' => $currentTab,
                'navigation' => $navigation,
                'role' => $role
            ]);
        }

        if($currentTab === 'reports')
        {
            return view('reports', [
                'current' => $currentTab,
                'navigation' => $navigation,
                'role' => $role
            ]);
        }

        if($currentTab === 'dashboard') {
            return view('dashboard', [
                'current' => $currentTab,
                'navigation' => $navigation,
                'role' => $role,
            ]);
        }

        return view('dashboard', [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
        ])->with(['page', 'Dashboard']);
	}
}
