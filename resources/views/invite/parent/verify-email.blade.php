@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Verify email" : "Verify email HU"  }} | PupilPay
@endsection
@section('content')
    <parent-verify-email :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></parent-verify-email>
@endsection



