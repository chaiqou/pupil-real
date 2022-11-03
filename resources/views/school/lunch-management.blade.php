@extends('layouts.dashboard')
@section('content')
<main class="py-12 px-6 flex justify-between mx-2 ">
    <merchant-calendar :months={{ 11 }}></merchant-calendar>
    <merchant-form></merchant-form>
</main>
@endsection
