@extends('layouts.dashboard')
@section('content')
<main class="flex">
    <div class="py-6">
      <div class="mx-auto max-w-9xl px-12 sm:px-8 md:px-6">
      <div class="py-4 flex space-x-5 2xl:space-x-10 ">
        <calendar class="hidden sm:flex" :months={{ 11 }}></calendar>
        <parent-lunch-details></parent-lunch-details>
        </div>
      </div>
    </div>
</main>
@endsection
