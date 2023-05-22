@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Dashboard' : 'Irányítópult'}} | PupilPay
@endsection
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 mt-8">
    <school-dashboard></school-dashboard>
    </div>
@endsection
