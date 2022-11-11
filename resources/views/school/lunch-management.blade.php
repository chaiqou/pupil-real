@extends('layouts.dashboard')
@section('content')
<div class="flex px-12">
    <calendar class="hidden lg:flex" :months={{ 11 }}></calendar>
    <lunch-form class="w-screen mt-20  pb-8"></lunch-form>
</div>
@endsection
