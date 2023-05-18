@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Menus' : 'Menus HU'}} | PupilPay
@endsection
@section('content')
  <parent-menu-calendar :student-id="{{ $studentId }}" ></parent-menu-calendar>
@endsection
