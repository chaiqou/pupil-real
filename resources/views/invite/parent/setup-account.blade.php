@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    Setup account | PupilPay
@endsection
@section('content')
    <parent-setup-account :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></parent-setup-account>
@endsection
