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
        if($user->hasRole('school'))
        {
            $navigation =
                [
                    ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '#', 'current' => true],
                    ['name' => 'projects', 'icon' => 'HomeIcon', 'href' => '#', 'current' => true],
                ];
        }
		return view('dashboard', [
            'navigation' => $navigation
        ])->with('page', 'Dashboard');
	}
}
