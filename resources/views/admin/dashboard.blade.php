@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Dashboard' : 'Dashboard HU'}} | PupilPay
@endsection
@section('content')
   <admin-dashboard></admin-dashboard>
@endsection
