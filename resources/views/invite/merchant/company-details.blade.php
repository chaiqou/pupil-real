@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    Company details | PupilPay
@endsection
@section('content')
    <merchant-company-details :unique-id="{{json_encode($uniqueID)}}"></merchant-company-details>
@endsection
