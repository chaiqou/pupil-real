@extends('layouts.dashboard')
@section('content')
    <main class="flex-1">
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">{{$student->first_name}}'s Dashboard</h1>
                <dashboard :student-id="{{$studentId}}"></dashboard>
            </div>
        </div>
    </main>
@endsection
