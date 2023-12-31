@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Lunch details' : 'Lunch details HU'}} | PupilPay
@endsection
@section('content')
<main class="flex">
    <div class="py-6">
      <div class="mx-auto max-w-7xl px-12 sm:px-8 md:px-6">
      <div class="py-4 flex space-x-5 2xl:space-x-10 ">
        <parent-calendar class="hidden sm:flex" :months={{ 11 }}></parent-calendar>
        <parent-lunch-details :student-id="{{$studentId}}"></parent-lunch-details>
        </div>
      </div>
    </div>
</main>
@endsection
