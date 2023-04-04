@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    Set up Billingo Access | PupilPay
@endsection
@section('content')
    <merchant-billingo-verify :unique-id="{{json_encode($uniqueID)}}"></merchant-billingo-verify>
@endsection
