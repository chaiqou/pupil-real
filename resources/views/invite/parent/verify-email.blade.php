@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    Verify email | PupilPay
@endsection
@section('content')
    <parent-verify-email :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></parent-verify-email>
@endsection



