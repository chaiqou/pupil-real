<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transaction;
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
        $students = Auth::user()->students->all();

        if($user->hasRole('admin'))
        {
            $role = 'admin';
            $navigation =
                [
                    ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '#', 'current' => true],
                ];
        }
        if($user->hasRole('parent'))
        {
            $role = 'parent';
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => "/parent/dashboard/".$student->id, 'current' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' =>  "/parent/transactions/".$student->id, 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => "/parent/students/".$student->id, 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => "/parent/knowledge-base/".$student->id, 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => "/parent/settings/".$student->id, 'current' => false],
                ];

        }

        $currentTab = request()->route()->getName();

        $transactions = Transaction::where('student_id', $user->id)->with('merchant')->get();


        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
            'student' => $student,
            'students' => $students,
            'transactions' => $transactions,
        ])->with(['page', 'Dashboard']);
	}



    public function school(): View
    {
        $navigation = [];
        $role = '';
        $user = auth()->user();
        $students = $user->students->all();
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
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => '/school/dashboard', 'current' => false],
                    ['name' => 'Lunch management', 'icon' => 'BuildingOffice2Icon', 'href' => '/school/lunch-management', 'current' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' => '/school/transactions', 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => '/school/students', 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => '/school/knowledge-base', 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => '/school/settings', 'current' => false],
                ];
            $role = 'school';
        }

        $currentTab = request()->route()->getName();

        $transactions = Transaction::where('merchant_id', $user->id)->with('merchant')->get();


        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
            'students' => $students,
            'student' => $user,
            'transactions' => $transactions,
        ])->with(['page', 'Dashboard']);
    }
}
