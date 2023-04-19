@extends('layouts.dashboard')
@section('content')

    <school-settings user-id="{{json_encode($user->id)}}"></school-settings>
@endsection
