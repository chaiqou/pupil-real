@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Verify email" : "Verify email HU"  }} | PupilPay
@endsection
@section('content')
    <merchant-verify-email :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></merchant-verify-email>
@endsection
