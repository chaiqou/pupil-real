@extends('layouts.dashboard')
@section('content')

    <school-settings :user-id="{{$user->id}}"></school-settings>
@endsection
