@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Setup Billingo Access" : "Setup Billingo Access HU"  }} | PupilPay
@endsection
@section('content')
    <merchant-billingo-verify :unique-id="{{json_encode($uniqueID)}}"></merchant-billingo-verify>
@endsection
