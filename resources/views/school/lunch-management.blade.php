@extends('layouts.dashboard')
@section('content')
<main class="py-12 px-6 flex justify-between mx-2 ">
    <calendar :months={{ 11 }}></calendar>
    <lunch-form></lunch-form>
</main>
@endsection
