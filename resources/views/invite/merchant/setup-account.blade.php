@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    Set up account | PupilPay
@endsection
@section('hide-language')
@endsection
@section('content')
    <merchant-setup-account :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></merchant-setup-account>
@endsection
