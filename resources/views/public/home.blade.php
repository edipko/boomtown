@extends('layouts.app')

@section('content')
    <!-- Page container with dark background -->
    <div class="relative bg-black text-white min-h-screen">

        <!-- Background image -->
        <img class="fixed top-0 left-0 h-screen w-full object-cover opacity-75" src="{{ asset('images/boomtown-bg.jpg') }}" alt="Boomtown Background">

        <!-- Main content container with 85% width -->
        <div class="relative z-10 flex flex-col items-center space-y-12 pt-10 w-11/12 mx-auto">

            <!-- Hero Section with Band Logo or Title -->
            <!--<div class="hero-section w-full h-screen md:h-96 bg-black overflow-hidden rounded-lg shadow-xl relative text-center">
                <img class="w-full h-full object-cover absolute top-0 opacity-50 filter grayscale contrast-200" src="{{ asset('images/boomtown_banner_1.png') }}" alt="Boomtown Band">

                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <h1 class="text-6xl font-bold uppercase tracking-wider"></h1>
                    <p class="text-xl mt-2"></p>
                </div>
            </div>
-->
            <div class="hero-section w-11/12 mx-auto flex items-center justify-center">
                <img src="{{ asset('images/boomtown_banner_1_transparent.png') }}" alt="Boomtown" class="w-full h-auto rounded-lg shadow-lg">
            </div>

            <!-- About Section -->
            <section class="w-full bg-gradient-to-b from-gray-800 to-gray-900 p-8 rounded-lg shadow-xl">
                <h2 class="text-3xl font-bold mb-4">About Boomtown</h2>
                <p class="text-lg">
                    Boomtown is a high-energy band bringing incredible music to every stage. Known for their captivating performances and tight musicianship, they’ve been rocking audiences for over a decade.
                </p>
            </section>

            <!-- Events Section - using Livewire -->
            <section class="w-full my-8">
                @livewire('event-list')
            </section>

            <!-- Mailing List Signup Section -->
           <section class="w-full my-8">
                @livewire('mailing-list-signup')
            </section>


            <!-- Band Profiles Section -->
            <!--<section class="w-full bg-gray-900 p-8 rounded-lg shadow-xl">
                <h2 class="text-3xl font-bold mb-4">Band Members</h2>
                <p class="text-lg">Coming soon: profiles of each band member!</p>
            </section>
            -->
        </div>

        <!-- Footer -->
        <footer class="mt-10 text-center py-6 text-gray-400 text-sm uppercase tracking-widest">
            <div>
            <div>&copy; 2024 Boomtown Band. All rights reserved.</div>
            <div class="space-x-4">
                <a href="{{ route('privacy') }}" class="hover:text-white">Privacy Policy</a>
                <a href="{{ route('login') }}" class="hover:text-white">Login</a>
                <a href="{{ url('/') }}" class="hover:text-white">Home</a>
            </div>
            </div>
        </footer>
    </div>
@endsection
