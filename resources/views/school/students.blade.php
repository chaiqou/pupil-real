@extends('layouts.dashboard')
@section('content')
    <div class=" px-4 sm:px-6 lg:px-8 mt-32">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto flex items-end justify-between">
               <div>
                   <h1 class="text-xl font-semibold text-gray-900">All Students</h1>
                   <p class="mt-2 text-sm text-gray-700">A list of all the students depend to YOUR_SCHOOL  including their name, transaction amount/type/date and merchant nickname.</p>
               </div>
                <a href="{{route('school.invite')}}" class="bg-green-500 hover:bg-green-600 rounded-md text-white px-4 py-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                    <p class="ml-1.5">Manage invites</p>
                </a>

            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <school-students  :school-id="{{$schoolId}}"  :student="{{$student}}"></school-students>
                </div>
            </div>
        </div>
    </div>
@endsection
