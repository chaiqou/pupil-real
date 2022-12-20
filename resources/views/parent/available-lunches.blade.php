@extends('layouts.dashboard')
@section('content')
<parent-lunch-list :student-id="{{$studentId}}"></parent-lunch-list>
@endsection
