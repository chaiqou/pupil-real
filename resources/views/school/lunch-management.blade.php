@extends('layouts.dashboard')
@section('content')
<div class="flex md:py-12 md:px-12">
    <calendar class="hidden lg:flex" :months={{ 11 }}></calendar>
    <lunch-form class="md:w-full  lg:w-1/3 px-6 pb-8"></lunch-form>
</div>
@endsection
