<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
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
            // use lower case characters into the name with snake case (even if it is subpage, just for sure, even tho it is no need for it for subpages), because in DashboardNavigation vue we use translates (localization)
            $navigation =
                [
                    ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '/parent/dashboard/'.$student->id, 'current' => false],
                    ['name' => 'transactions', 'icon' => 'ListBulletIcon', 'href' => '/parent/transactions/'.$student->id, 'current' => false],
                    ['name' => 'knowledge_base', 'icon' => 'BookOpenIcon', 'href' => '/parent/knowledge-base/'.$student->id, 'current' => false],
                    ['name' => 'available_lunches', 'icon' => 'CakeIcon', 'href' => '/parent/available-lunches/'.$student->id, 'current' => false],
                    ['name' => 'lunch_details', 'icon' => 'none', 'href' => '/parent/lunch-details/'.$student->id, 'current' => false, 'hidden' => true, 'parentPage' => 'available_lunches'],
                    ['name' => 'menus', 'icon' => 'ClipboardDocumentListIcon', 'href' => '/parent/menus/'.$student->id, 'current' => false],
                    ['name' => 'settings', 'icon' => 'Cog8ToothIcon', 'href' => '/parent/settings/'.$student->id, 'current' => false],
                ];
        }

        $currentTab = request()->route()->getName();

        if (auth()->user()->hasRole('2fa') && session()->get('is_2fa_verified') === false) {
            return redirect()->route('2fa.form');
        }

        if (auth()->user()->hasRole('2fa')) {
            $twoFa = 1;
        }

        // Check the current chosen language of the user, set locale of current user-s language
        if (auth()->user()->language === 'en') {
            app()->setLocale('en');
        } elseif (auth()->user()->language === 'hu') {
            app()->setLocale('ka');
        } else {
            app()->setLocale('en');
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
            // use lower case characters into the name with snake case (even if it is subpage, just for sure, even tho it is no need for it for subpages), because in DashboardNavigation vue we use translates (localization)
            $navigation =
                [
                    ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '/school/dashboard', 'current' => false],
                    ['name' => 'lunch_management', 'icon' => 'BuildingOffice2Icon', 'href' => '/school/lunch-management', 'current' => false],
                    ['name' => 'menu_management', 'icon' => 'ClipboardDocumentListIcon', 'href' => '/school/menu-management', 'current' => false],
                    ['name' => 'transactions', 'icon' => 'ListBulletIcon', 'href' => '/school/transactions', 'current' => false],
                    ['name' => 'students', 'icon' => 'UsersIcon', 'href' => '/school/students', 'current' => false],
                    ['name' => 'terminals', 'icon' => 'CommandLineIcon', 'href' => '/school/terminals', 'current' => false],
                    ['name' => 'knowledge_base', 'icon' => 'BookOpenIcon', 'href' => '/school/knowledge-base', 'current' => false],
                    ['name' => 'settings', 'icon' => 'Cog8ToothIcon', 'href' => '/school/settings', 'current' => false],
                    ['name' => 'invite', 'icon' => 'nothing', 'href' => '/school/invite', 'current' => false, 'hidden' => true, 'parentPage' => 'students'],
                    ['name' => 'add_lunch', 'icon' => 'nothing', 'href' => '/school/add-lunch', 'current' => false, 'hidden' => true, 'parentPage' => 'lunch_management'],
                    ['name' => 'lunch_management_edit', 'icon' => 'nothing', 'href' => '/school/lunch-management/{lunch_id}/edit', 'current' => false, 'hidden' => true, 'parentPage' => 'lunch_management'],
                ];
            $role = 'school';
        }

        $currentTab = request()->route()->getName();

        if (session()->get('is_2fa_verified') === false) {
            return redirect()->route('2fa.form');
        }

        return view($currentTab, [
            'current' => $currentTab,
            'navigation' => $navigation,
            'role' => $role,
            'students' => $students,
            'student' => $user,
            'user' => $user,
            'schoolId' => $user->school_id,
            'lunchId' => $lunchId,
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
            // use lower case characters into the name with snake case (even if it is subpage, just for sure, even tho it is no need for it for subpages), because in DashboardNavigation vue we use translates (localization)
            $navigation =
                [
                    ['name' => 'dashboard', 'icon' => 'HomeIcon', 'href' => '/admin/dashboard', 'current' => false],
                    ['name' => 'students', 'icon' => 'UsersIcon', 'href' => '/admin/students', 'current' => false],
                    ['name' => 'invite', 'icon' => 'nothing', 'href' => '/admin/invite', 'current' => false, 'hidden' => true, 'parentPage' => 'students'],
                    ['name' => 'schools', 'icon' => 'BuildingOffice2Icon', 'href' => '/admin/schools', 'current' => false],
                    ['name' => 'merchants', 'icon' => 'nothing', 'href' => '/admin/school/{school_id}/merchants', 'current' => false, 'hidden' => true, 'parentPage' => 'schools'],
                    ['name' => 'merchant_invites', 'icon' => 'nothing', 'href' => '/admin/merchant-invites', 'current' => false, 'hidden' => true, 'parentPage' => 'schools'],
                    ['name' => 'settings', 'icon' => 'Cog8ToothIcon', 'href' => '/admin/settings', 'current' => false],
                ];
        }
        $currentTab = request()->route()->getName();
        if (session()->get('is_2fa_verified') === false) {
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
