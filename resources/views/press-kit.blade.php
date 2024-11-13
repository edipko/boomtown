@extends('layouts.app')

@section('content')
    <!-- Page container with dark background -->
    <div class="relative bg-black text-white min-h-screen flex flex-col items-center pt-10">

        <!-- Back to Main Public Page Link -->
        <div class="w-11/12 mx-auto mb-6">
            <a href="{{ url('/') }}" class="text-blue-400 hover:underline text-lg">
                &larr; Back to Main Page
            </a>
        </div>

        <!-- Press Kit Content -->
        <section class="w-11/12 mx-auto bg-gray-900 p-8 rounded-lg shadow-xl">
            <h2 class="text-3xl font-bold mb-4">Digital Press Kit</h2>
            <p class="text-lg text-gray-300">Coming Soon</p>
        </section>
    </div>
@endsection
