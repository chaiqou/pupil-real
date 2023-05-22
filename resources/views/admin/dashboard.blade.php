@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Dashboard' : 'Irányítópult'}} | PupilPay
@endsection
@section('content')
   <admin-dashboard></admin-dashboard>
@endsection
