@extends('layouts.invite.merchant.onboarding-layout')
@section('title')
    Personal form | PupilPay
@endsection
@section('content')
    <merchant-personal-form :unique-id="{{json_encode($uniqueID)}}"></merchant-personal-form>
@endsection
