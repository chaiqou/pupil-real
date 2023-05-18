@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Personal form" : "Personal form HU"  }} | PupilPay
@endsection
@section('content')
    <merchant-personal-form :unique-id="{{json_encode($uniqueID)}}"></merchant-personal-form>
@endsection
