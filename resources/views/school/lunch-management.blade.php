@extends('layouts.dashboard')
@section('content')
<main class="flex">
    <div class="py-6">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-6">
      <div class="py-4 flex">
        <calendar class="hidden lg:flex" :months={{ 11 }}></calendar>
        <lunch-form></lunch-form>
        </div>
      </div>
    </div>
</main>
@endsection
