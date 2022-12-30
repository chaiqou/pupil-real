<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BillingoController;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\School;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NavigationController extends Controller
{
    public function parent($student_id): View|RedirectResponse
    {
        $navigation = [];
        $role = '';
        $student = Student::where('id', $student_id)->first();
        $user = Auth::user();
        $userInfo = json_decode($user->user_information);
        $students = Auth::user()->students->all();
        $twoFa = 0;
        if ($user->hasRole('parent')) {
            $role = 'parent';
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => '/parent/dashboard/'.$student->id, 'current' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' => '/parent/transactions/'.$student->id, 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => '/parent/knowledge-base/'.$student->id, 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => '/parent/settings/'.$student->id, 'current' => false],
                    ['name' => 'Available Lunches', 'icon' => 'CakeIcon', 'href' => '/parent/available-lunches/'.$student->id, 'current' => false],
                    ['name' => 'Lunch Details', 'icon' => 'none', 'href' => '/parent/lunch-details/'.$student->id, 'current' => false, 'hidden' => true, 'parentPage' => 'Available Lunches'],
                ];
        }

        $currentTab = request()->route()->getName();

        if (auth()->user()->hasRole('2fa') && auth()->user()->is_verified === 0) {
            return redirect()->route('2fa.form');
        }

        if (auth()->user()->hasRole('2fa')) {
            $twoFa = 1;
        }

        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
            'student' => $student,
            'students' => $students,
            'studentId' => $student->id,
            'user' => $user,
            'userInfo' => $userInfo,
            'twoFa' => $twoFa,
        ])->with(['page', 'Dashboard']);
    }

    public function school(): View|RedirectResponse
    {
        $navigation = [];
        $role = '';
        $user = auth()->user();
        $students = $user->students->all();
        $lunchId = request()->lunch_id;

        if ($user->hasRole('school')) {
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => '/school/dashboard', 'current' => false],
                    ['name' => 'Lunch management', 'icon' => 'BuildingOffice2Icon', 'href' => '/school/lunch-management', 'current' => false],
                    ['name' => 'Menu Management', 'icon' => 'ClipboardDocumentListIcon', 'href' => '/school/menu-management', 'curreunt' => false],
                    ['name' => 'Transactions', 'icon' => 'ListBulletIcon', 'href' => '/school/transactions', 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => '/school/students', 'current' => false],
                    ['name' => 'Terminals', 'icon' => 'CommandLineIcon', 'href' => '/school/terminals', 'current' => false],
                    ['name' => 'Knowledge base', 'icon' => 'BookOpenIcon', 'href' => '/school/knowledge-base', 'current' => false],
                    ['name' => 'Settings', 'icon' => 'Cog8ToothIcon', 'href' => '/school/settings', 'current' => false],
                    ['name' => 'Invite', 'icon' => 'nothing', 'href' => '/school/invite', 'current' => false, 'hidden' => true, 'parentPage' => 'Students'],
                    ['name' => 'Add Lunch', 'icon' => 'nothing', 'href' => '/school/add-lunch', 'current' => false, 'hidden' => true, 'parentPage' => 'Lunch management'],
                    ['name' => 'Lunch management edit', 'icon' => 'nothing', 'href' => '/school/lunch-management/{lunch_id}/edit', 'current' => false, 'hidden' => true, 'parentPage' => 'Lunch management'],
                ];
            $role = 'school';
        }

        $currentTab = request()->route()->getName();

        $merchantIdByUser = Merchant::where('user_id', auth()->user()->id)->first()->id;

        if (auth()->user()->is_verified === 0) {
            return redirect()->route('2fa.form');
        }

        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
            'students' => $students,
            'student' => $user,
            'schoolId' => $user->school_id,
            'lunchId' => $lunchId,
            'merchantIdByUser' => $merchantIdByUser,
        ])->with(['page', 'Dashboard']);
    }

    public function admin(): View|RedirectResponse
    {
        $navigation = [];
        $role = '';
        $user = Auth::user();
        $students = $user->students->all();
        if ($user->hasRole('admin')) {
            $role = 'admin';
            $navigation =
                [
                    ['name' => 'Dashboard', 'icon' => 'HomeIcon', 'href' => '/admin/dashboard', 'current' => false],
                    ['name' => 'Students', 'icon' => 'UsersIcon', 'href' => '/admin/students', 'current' => false],
                    ['name' => 'Invite', 'icon' => 'nothing', 'href' => '/admin/invite', 'current' => false, 'hidden' => true, 'parentPage' => 'Students'],
                    ['name' => 'Schools', 'icon' => 'BuildingOffice2Icon', 'href' => '/admin/schools', 'current' => false],
                    ['name' => 'Merchants', 'icon' => 'nothing', 'href' => '/admin/school/{school_id}/merchants', 'current' => false, 'hidden' => true, 'parentPage' => 'Schools'],
                    ['name' => 'Merchant Invites', 'icon' => 'nothing', 'href' => '/admin/merchant-invites', 'current' => false, 'hidden' => true, 'parentPage' => 'Schools'],
                ];
        }
        $currentTab = request()->route()->getName();
        if (auth()->user()->is_verified === 0) {
            return redirect()->route('2fa.form');
        }
        $school = School::where('id', request()->school_id)->first();

        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'students' => $students,
            'student' => $user,
            'role' => $role,
            'user' => $user,
            'school' => $school,
        ])->with(['page', 'Dashboard']);
    }
}
