@extends('layouts.dashboard')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">My transactions</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the transactions in your account including your name, transaction amount/type/date and merchant nickname.</p>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <parent-transactions :student-id="{{$studentId}}"  :student="{{$student}}"></parent-transactions>
                </div>
            </div>
        </div>
    </div>
@endsection
