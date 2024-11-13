<!-- resources/views/components/book-the-band.blade.php -->
<section class="w-full bg-gray-900 p-8 rounded-lg shadow-xl my-8">
    <h2 class="text-3xl font-bold mb-4">Book the Band</h2>
    <form id="gigLeadForm">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-white">Name</label>
            <input type="text" id="name" name="name" required class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600" placeholder="Your Name">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-white">Email</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600" placeholder="Your Email">
        </div>
        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-white">Telephone</label>
            <input type="text" id="telephone" name="telephone" required class="mt-1 block w-full rounded-md bg-gray-800 text-white border-gray-600" placeholder="Your Telephone">
        </div>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Submit</button>
    </form>

    <div id="gigLeadSuccessMessage" class="mt-4 text-green-500 hidden">
        Your booking request has been received! We will contact you soon.
    </div>

    <!-- Link to Digital Press Kit -->
    <div class="mt-4">
        <a href="{{ route('press-kit') }}" class="text-blue-400 underline">View Digital Press Kit</a>
    </div>
</section>
