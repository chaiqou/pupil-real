@extends('layouts.dashboard')
@section('content')
    <main >
        <div class="py-12">
            <div class="mx-2 max-w-7xl px-4 sm:px-6 md:px-8">
                <div class="py-4 flex justify-between">
                    <merchant-calendar :months={{ 11 }}></merchant-calendar>
                    <merchant-form></merchant-form>
                </div>
            </div>
        </div>
    </main>
@endsection
