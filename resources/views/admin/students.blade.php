@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Students' : 'Students HU'}} | PupilPay
@endsection
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 mt-16 md:mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto flex items-end justify-between">
               <div>
                   <h1 class="text-xl font-semibold text-gray-900">{{__('all_students')}}</h1>
                   <p class="mt-2 text-sm text-gray-700">{{__('a_list_of_all_the_students_of_all_the_schools_including_their_name_transaction_amount_type_date_and_merchant_nickname')}}.</p>
               </div>
                <div>
                    <a href="{{route('admin.invite')}}" class="hidden md:flex bg-blue-600 hover:bg-blue-700 w-fit rounded-md text-white px-4 py-2 items-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <p class="ml-1.5">{{__('manage_invites')}}</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <admin-students></admin-students>
                </div>
            </div>
        </div>
    </div>
@endsection
