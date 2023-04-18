@extends('layouts.dashboard')
@section('content')

<admin-settings user-id="{{json_encode($user->id)}}"></admin-settings>
@endsection
