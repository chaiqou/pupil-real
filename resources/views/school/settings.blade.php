@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Settings' : 'Settings HU'}} | PupilPay
@endsection
@section('content')
    <school-settings :user-id="{{$user->id}}"></school-settings>
@endsection
