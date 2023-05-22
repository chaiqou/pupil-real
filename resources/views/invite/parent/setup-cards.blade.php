@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    {{ session()->get('locale') === 'en' ? "Setup cards" : "Setup cards HU"  }} | PupilPay
@endsection
@section('content')
    <parent-setup-cards :unique-id="{{json_encode($uniqueID)}}"></parent-setup-cards>
@endsection

