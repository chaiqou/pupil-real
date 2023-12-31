@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Merchants' : 'Kereskedők'}} | PupilPay
@endsection
@section('content')
         <admin-merchants-header :school="{{$school}}"></admin-merchants-header>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <admin-merchants :school="{{$school}}"></admin-merchants>
                    </div>
                </div>
            </div>
    </div>
@endsection
