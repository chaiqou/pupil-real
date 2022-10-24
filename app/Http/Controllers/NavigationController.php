<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
	public function index($student_id): View
	{
        $navigation = [];
        $role = '';
        $student = Student::where('id', $student_id)->first();
        $user = Auth::user()->where('id', $student->id)->first();

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
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => $student->id, 'current' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' =>  "/parent/transactions/".$student->id, 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => "/parent/students/".$student->id, 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => "/parent/knowledge-base/".$student->id, 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => "/parent/settings/".$student->id, 'current' => false],
                ];
            $role = 'parent';
        }

        $currentTab = request()->route()->getName();

        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
            'student' => $user,
        ])->with(['page', 'Dashboard']);
	}
}
