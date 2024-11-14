@extends('layouts.app')

@section('content')
    <!-- Page container with dark background -->
    <div class="relative bg-black text-white min-h-screen">


        <!-- Background image -->
        <img class="fixed top-0 left-0 h-screen w-full object-cover opacity-75" src="{{ asset('images/boomtown-bg.jpg') }}" alt="Boomtown Background">

        <!-- Social media links -->
        <div class="absolute top-4 left-4 z-20">
            <a href="https://www.facebook.com/profile.php?id=61558485951813" target="_blank" class="hover:opacity-80 inline-flex items-center">
                <img src="{{ asset('images/Facebook_Logo_Primary.png') }}" alt="Facebook" class="w-8 sm:w-10 md:w-12 lg:w-14 xl:w-16 h-auto">
            </a>
        </div>




        <!-- Main content container with 85% width -->
        <div class="relative z-10 flex flex-col items-center space-y-12 pt-10 w-11/12 mx-auto">




            <!-- Hero Section with Band Logo or Title -->
            <div class="hero-section w-11/12 mx-auto flex items-center justify-center">
                <img src="{{ asset('images/boomtown_banner_1_transparent.png') }}" alt="Boomtown" class="w-full h-auto rounded-lg shadow-lg">
            </div>

            <!-- About Section -->
            <section class="w-full bg-gradient-to-b from-gray-800 to-gray-900 p-8 rounded-lg shadow-xl">
                <h2 class="text-3xl font-bold mb-4">About Boomtown</h2>
                <p class="text-lg">
                    {{ $aboutContent->content ?? 'Boomtown is a high-energy band bringing incredible music to every stage...' }}
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


            <!-- Book the Band Section -->
            <x-book-the-band />


            <!-- Band Profiles Section -->
            <!--<section class="w-full bg-gray-900 p-8 rounded-lg shadow-xl">
                <h2 class="text-3xl font-bold mb-4">Band Members</h2>
                <p class="text-lg">Coming soon: profiles of each band member!</p>
            </section>
            -->
        </div>

        <!-- Footer -->
        <footer class="relative z-20 mt-10 text-center py-6 text-gray-400 text-sm uppercase tracking-widest bg-black">
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

    <script>
        document.getElementById('gigLeadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch("{{ route('giglead.store') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',  // Ensures the server knows we expect JSON
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('gigLeadSuccessMessage').classList.remove('hidden');
                        document.getElementById('gigLeadForm').reset();
                    }
                })
                .catch(error => console.error('Error:', error));
        });

    </script>

@endsection
