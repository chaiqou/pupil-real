@extends('layouts.dashboard')
@section('content')
   <calendar :classes="['!w-full']" :months={{ 11 }}></calendar>
@endsection
