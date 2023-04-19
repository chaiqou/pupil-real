@extends('layouts.dashboard')
@section('content')
    <div class=" px-4 sm:px-6 lg:px-8 mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">{{__('all_transactions')}}</h1>
                <p class="mt-2 text-sm text-gray-700">
                {{__('a_list_of_all_the_transactions_depend_to_your_school_including_students_name_transaction_amount_type_date_and_merchant_nickname')}}.</p>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <school-transactions :school-id="{{$schoolId}}"  :student="{{$student}}"></school-transactions>
                </div>
            </div>
        </div>
    </div>
@endsection
