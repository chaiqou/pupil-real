@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Lunch Management Edit' : 'Lunch Management Edit HU'}} | PupilPay
@endsection
@section('content')
<lunch-edit-page></lunch-edit-page>
@endsection
