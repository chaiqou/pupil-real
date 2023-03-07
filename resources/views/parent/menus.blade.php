@extends('layouts.dashboard')
@section('content')
  <parent-menu-calendar :student-id="{{ $studentId }}" ></parent-menu-calendar>
@endsection
