@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Company details" : "Company details HU"  }} | PupilPay
@endsection
@section('content')
    <merchant-company-details :unique-id="{{json_encode($uniqueID)}}"></merchant-company-details>
@endsection
