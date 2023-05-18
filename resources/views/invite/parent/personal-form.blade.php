@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Personal form" : "Personal form HU"  }} | PupilPay
@endsection
@section('content')
    <parent-personal-form :unique-id="{{json_encode($uniqueID)}}"></parent-personal-form>
@endsection
