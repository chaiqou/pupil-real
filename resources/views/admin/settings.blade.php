@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Settings' : 'Beállítások'}} | PupilPay
@endsection
@section('content')
<admin-settings user-id="{{json_encode($user->id)}}"></admin-settings>
@endsection
