@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Merchant Invites' : 'Kereskedői meghívók'}} | PupilPay
@endsection
@section('content')
         <admin-merchant-invites-header :school="{{$school}}"></admin-merchant-invites-header>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <admin-merchant-invites :school="{{$school}}"></admin-merchant-invites>
                    </div>
                </div>
            </div>
    </div>
@endsection
