<section class="w-full bg-gray-900 p-8 rounded-lg shadow-xl my-8">
    <h2 class="text-3xl font-bold mb-4">Book the Band</h2>

    @if (session('message'))
        <div class="text-green-500 p-3 mb-4">{{ session('message') }}</div>
    @endif

    @if (session('error'))
        <div class="text-red-500 p-3 mb-4">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="submitForm">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-white">Name</label>
            <input type="text" wire:model="name" id="name" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Name">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-white">Email</label>
            <div class="flex">
                <input type="email" wire:model="email" id="email" required
                       class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                       placeholder="Your Email">
                <button type="button" wire:click="sendVerificationCode" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">
                    Verify
                </button>
            </div>
        </div>

        @if ($codeSent)  {{-- ✅ This will now work because `$codeSent` is properly set --}}
        <div class="mb-4">
            <label for="verification_code" class="block text-sm font-medium text-white">Enter Verification Code</label>
            <input type="text" wire:model="verification_code" id="verification_code" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="6-digit Code">
            <button type="button" wire:click="verifyCode" class="mt-2 bg-green-500 text-white px-4 py-2 rounded">
                Confirm Code
            </button>
        </div>
        @endif

        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-white">Telephone</label>
            <input type="text" wire:model="telephone" id="telephone" required
                   class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                   placeholder="Your Telephone">
        </div>

        <div class="mb-4">
            <label for="event_information" class="block text-sm font-medium text-white">Event Information</label>
            <textarea wire:model="event_information" id="event_information"
                      class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600"
                      placeholder="Details about your event..."></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded" @if(!$isVerified) disabled @endif>
            Submit
        </button>
    </form>
</section>

