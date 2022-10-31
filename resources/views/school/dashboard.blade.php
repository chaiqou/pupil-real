@extends('layouts.dashboard')
@section('content')
    <main class="flex-1">
        <div class="py-6">
            <div class="mx-2 max-w-7xl px-4 sm:px-6 md:px-8">
                <div class="py-4 flex">
                    <merchant-calendar></merchant-calendar>
                    <merchant-form></merchant-form>
                </div>
            </div>
        </div>
    </main>
@endsection
