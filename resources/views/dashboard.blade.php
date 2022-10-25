@extends('layouts.dashboard')
@section('content')
    <main class="flex-1">
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">John's Dashboard</h1>
            </div>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <div class="py-4">
                    <div class="flex h-96 items-center justify-center rounded-lg">
                        @include('components.cards.select-lunch')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
