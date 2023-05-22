@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Menu Management' : 'Menu Management HU'}} | PupilPay
@endsection
@section('content')
   <menu-calendar></menu-calendar>
@endsection
