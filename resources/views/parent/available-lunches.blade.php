@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Available Lunches' : 'Available Lunches HU'}} | PupilPay
@endsection
@section('content')
<parent-lunch-list :student-id="{{$studentId}}"></parent-lunch-list>
@endsection
