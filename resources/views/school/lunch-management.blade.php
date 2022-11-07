@extends('layouts.dashboard')
@section('content')
<div class="flex md:py-12 md:px-12">
    <calendar class="hidden lg:flex" :months={{ 11 }}></calendar>
    <lunch-form class="lg:w-1/2 px-4 pb-6"></lunch-form>
</div>
@endsection
