@extends('layouts.dashboard')
@section('content')
<lunch-list></lunch-list>
<a href="{{route('school.add-lunch')}}" class="hidden md:flex bg-green-500 hover:bg-green-600 w-fit rounded-md text-white px-4 py-2 items-center">
    <p class="ml-1.5">Add Lunch</p>
</a>
@endsection
