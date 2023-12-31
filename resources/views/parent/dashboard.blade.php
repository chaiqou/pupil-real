@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Dashboard' : 'Irányítópult'}} | PupilPay
@endsection
@section('content')
    <main class="flex-1">
        <div class="py-6">
            <div class="mx-auto  px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">{{$student->first_name}}{{auth()->user()->language === 'en' ? "'s Dashboard" : ' Irányítópultja'}}</h1>
                 <parent-dashboard :student-id="{{$studentId}}"></parent-dashboard>
            </div>
        </div>
    </main>
@endsection
