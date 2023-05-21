@extends('layouts.dashboard')
@section('title')
    {{auth()->user()->language === 'en' ? 'Settings' : 'Settings HU'}} | PupilPay
@endsection
@section('content')
<div class="flex min-h-full md:ml-32 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-xl space-y-8">
        @error('*')
        <div class="rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">{{ $message }}</h3>
                </div>
            </div>
        </div>
        @enderror
        <form id="form" method="POST" action="{{route('parent.settings_submit', ['student_id' => request()->student_id])}}" class="mt-8 space-y-6 w-full">
            @csrf
            <div class="bg-white p-8">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{auth()->user()->language === 'en' ? 'Personal Information' : "Personal Information HU"}}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{auth()->user()->language === 'en' ? 'Use your permanent residence' : "Használja az állandó lakcímét"}}.</p>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="last-name" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'Last name' : "Last name HU"}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{$user->last_name}}" required name="last_name" id="last_name" autocomplete="given-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="first-name" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'First name' : "First name HU"}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{$user->first_name}}" required name="first_name" id="first_name" autocomplete="family-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="middle-name" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'Middle name' : "Middle name HU"}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{$user->middle_name}}" name="middle_name" id="middle_name" autocomplete="additional-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="country" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'Country' : "Country HU"}}</label>
                        <div class="mt-1">
                            <select id="country" value="{{$userInfo->country}}" name="country" autocomplete="country-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 px-4 py-1.5 focus:ring-indigo-500 sm:text-sm">
                               <x-country-options></x-country-options>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="street_address" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'Street address' : "Street address HU"}}</label>
                        <div class="mt-1">
                            <input value="{{$userInfo->street_address}}" type="text" name="street_address" id="street_address" autocomplete="street-address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="city" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'City' : "City HU"}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{$userInfo->city}}" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="state" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'State / Province' : "State / Province HU"}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{$userInfo->state}}" name="state" id="state" autocomplete="address-level1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="zip" class="block text-sm font-medium text-gray-700">{{auth()->user()->language === 'en' ? 'ZIP / Postal code' : "ZIP / Postal code HU"}}</label>
                        <div class="mt-1">
                            <input type="text" value="{{$userInfo->zip}}" name="zip" id="zip" autocomplete="postal-code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">{{auth()->user()->language === 'en' ? 'Save' : "Save HU"}}</button>
                    </div>
                </div>
            </div>
        </form>
      <div>

          <div class="underline w-full h-[1px] bg-gray-400 opacity-30 my-3"></div>

          <two-factor-auth-modal :two-fa="{{$twoFa}}">
              <form method="POST" action="{{route('parent.two-fa')}}">
                  @csrf
                  <button class="{{$twoFa === 0 ? 'inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm' : 'inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm'}}" >
                          @if ($twoFa === 0)
                              @if (auth()->user()->language === 'en')
                                  Activate
                              @elseif (auth()->user()->language === 'hu')
                              Ativálja
                              @endif
                          @elseif ($twoFa === 1)
                              @if (auth()->user()->language === 'en')
                                  Deactivate
                              @elseif (auth()->user()->language === 'hu')
                              Deaktiválja
                              @endif
                          @endif
                  </button>
              </form>
          </two-factor-auth-modal>

          <change-password-modal :user-id="{{$user->id}}"></change-password-modal>
         <div class="ml-3 w-40">
             <set-language :user-id="{{$user->id}}"></set-language>
         </div>
         <div class="underline w-full h-[1px] bg-gray-400 opacity-30 my-3"></div>

          <div>
              <h1 class="px-3">{{auth()->user()->language === 'en' ? 'Student management' : "Student management HU"}}</h1>
              <p class="py-2 px-3 text-sm text-gray-500">
                  {{auth()->user()->language === 'en' ? 'List of all the available students at this account, also you are able to edit information here' : "List of all the available students at this account, also you are able to edit information here HU"}}.</p>
              <div class="-my-2 -mx-4 hidden md:block sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                          <parent-students :user-id="{{$user->id}}"></parent-students>
                      </div>
                      <div class="m-3 mb-10 mt-10 flex justify-end">
                          <a class="p-3 bg-indigo-600 hover:bg-indigo-700 shadow-sm border border-transparent rounded-md text-white" href="{{route('parent.create-student', ['user_id' => $user->id])}}">{{auth()->user()->language === 'en' ? 'Create new student' : 'Create new student HU'}}</a>
                      </div>
                  </div>
              </div>

              <div class="md:hidden block -my-2 -mx-4 overflow-x-scroll overflow-y-scroll md:overflow-hidden sm:-mx-6 lg:-mx-8">
                  <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                          <parent-students-mobile :user-id="{{$user->id}}"></parent-students-mobile>
                      </div>
                  </div>
              </div>
              <div class="m-3 mb-10 mt-10 md:hidden block">
                  <a class="p-3 bg-indigo-600 hover:bg-indigo-700 shadow-sm border border-transparent rounded-md text-white" href="{{route('parent.create-student', ['user_id' => $user->id])}}">{{auth()->user()->language === 'en' ? 'Create new student' : 'Create new student HU'}}</a>
              </div>
          </div>

    </div>
    </div>
</div>
@endsection
