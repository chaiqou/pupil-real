@extends('layouts.dashboard')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 mt-16 md:mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto flex items-end justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">All Schools</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the schools including their short/full/long name, details and school code.</p>
                </div>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <admin-schools></admin-schools>
                </div>
            </div>
        </div>
    </div>
@endsection
