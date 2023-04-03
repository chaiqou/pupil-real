@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    Setup cards | PupilPay
@endsection
@section('content')
    <parent-setup-cards :unique-id="{{json_encode($uniqueID)}}"></parent-setup-cards>
@endsection

