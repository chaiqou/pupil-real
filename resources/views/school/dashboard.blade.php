@extends('layouts.dashboard')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Students</h1>
                <p class="mt-2 text-sm text-gray-700">All students that have the same school as the merchant.</p>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="max-h-[21.4rem] overflow-y-scroll shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <school-dashboard-students  :school-id="{{$schoolId}}"  :student="{{$student}}"></school-dashboard-students>
                    </div>
                </div>
            </div>
        </div>


        <div>
            <h1 class="text-xl my-5 p-5">Last transactions</h1>
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block w-fit py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <school-dashboard-transactions :school-id="{{$schoolId}}"></school-dashboard-transactions>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
