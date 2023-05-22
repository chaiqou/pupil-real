@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Lunch Management' : 'Lunch Management HU'}} | PupilPay
@endsection
@section('content')
<lunch-list></lunch-list>
@endsection
