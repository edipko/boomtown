<div class="relative flex items-center justify-center bg-black py-10">
    <!-- Background Image with Overlay constrained to content height -->
    <div class="absolute bg-blue-800 inset-0 h-full w-full flex items-center justify-center">
        <img src="{{ asset('images/mailing-list-bg.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-30">
    </div>

    <!-- Form Container centered and sized for content -->
    <div class="relative z-10 bg-opacity-75 p-10 rounded-lg shadow-lg text-white w-11/12 max-w-lg mx-auto">
        <h2 class="text-3xl font-semibold text-center mb-6">Join the Mailing List</h2>

        @if ($successMessage)
            <div class="bg-green-500 text-white p-3 rounded mb-4">{{ $successMessage }}</div>
        @endif

        <form wire:submit.prevent="submit">
            <div class="mb-4">
                <input type="text" wire:model="name" placeholder="Full Name" class="w-full p-3 rounded focus:outline-none text-gray-900 placeholder-gray-400" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <input type="email" wire:model="email" placeholder="Email Address" class="w-full p-3 rounded focus:outline-none text-gray-900 placeholder-gray-400" />
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full p-3 bg-blue-500 hover:bg-blue-600 text-white rounded font-semibold">Sign Up</button>
        </form>
    </div>
</div>
