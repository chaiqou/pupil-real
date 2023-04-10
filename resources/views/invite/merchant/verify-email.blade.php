@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    Verify email | PupilPay
@endsection
@section('content')
    <merchant-verify-email :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></merchant-verify-email>
@endsection
