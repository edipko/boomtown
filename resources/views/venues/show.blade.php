<div class="bg-gray-800 bg-opacity-75 p-10 rounded-lg shadow-lg text-white">
    <h2 class="text-3xl font-semibold mb-6">{{ $venue->name }}</h2>
    <p class="text-lg"><strong>Address:</strong> {{ $venue->address }}, {{ $venue->city }}, {{ $venue->state }} {{ $venue->zip }}</p>
    <p class="text-lg"><strong>Telephone:</strong> {{ $venue->telephone }}</p>
</div>
