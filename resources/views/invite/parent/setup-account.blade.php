@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    Set up Account | Pupilpay
@endsection
@section('hide-language', true)
@section('content')
    <parent-setup-account :unique-id="{{json_encode($uniqueID)}}" :invite-email="{{json_encode($email)}}"></parent-setup-account>
@endsection
