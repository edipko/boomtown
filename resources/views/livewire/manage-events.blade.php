<div>
    <h2 class="text-xl font-bold mb-3">Upcoming Events</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Name</th>
            <th class="border p-2">Date</th>
            <th class="border p-2">Time</th>
            <th class="border p-2">Venue</th>
            <th class="border p-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($upcomingEvents as $event)
            <tr class="border">
                <td class="border p-2">{{ $event->name }}</td>
                <td class="border p-2">{{ $event->date }}</td>
                <td class="border p-2">{{ $event->time }}</td>
                <td class="border p-2">{{ $event->venue->name }}</td>
                <td class="border p-2">
                    <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600">Edit</a> |
                    <button wire:click="deleteEvent({{ $event->id }})" class="text-red-600">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="text-xl font-bold mt-6 mb-3">Past Events</h2>
    <table class="w-full border-collapse border border-gray-300">
        <thead>
        <tr class="bg-gray-200">
            <th class="border p-2">Name</th>
            <th class="border p-2">Date</th>
            <th class="border p-2">Time</th>
            <th class="border p-2">Venue</th>
            <th class="border
