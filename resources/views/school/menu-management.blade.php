@extends('layouts.dashboard')
@section('content')
   <menu-calendar :classes="['!w-full']" :months={{ 11 }}></menu-calendar>
@endsection
