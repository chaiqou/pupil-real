@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Terminals' : 'Terminals HU'}} | PupilPay
@endsection
@section('content')
            <school-terminals-header></school-terminals-header>
    <div class="mx-3 md:mx-7 mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <school-terminals :school-id="{{$schoolId}}"></school-terminals>
        </div>
    </div>
    </div>


@endsection
