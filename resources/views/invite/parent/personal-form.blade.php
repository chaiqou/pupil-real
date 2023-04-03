@extends('layouts.invite.parent.onboarding-layout')
@section('title')
    Personal form | PupilPay
@endsection
@section('content')
    <parent-personal-form :unique-id="{{json_encode($uniqueID)}}"></parent-personal-form>
@endsection
