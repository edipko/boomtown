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
        @forelse($upcomingEvents as $event)
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
        @empty
            <tr>
                <td colspan="5" class="text-center p-2">No upcoming events.</td>
            </tr>
        @endforelse
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
            <th class="border p-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($pastEvents as $event)
            <tr class="border text-gray-500">
                <td class="border p-2">{{ $event->name }}</td>
                <td class="border p-2">{{ $event->date }}</td>
                <td class="border p-2">{{ $event->time }}</td>
                <td class="border p-2">{{ $event->venue->name }}</td>
                <td class="border p-2">
                    <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600">Edit</a> |
                    <button wire:click="deleteEvent({{ $event->id }})" class="text-red-600">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-2">No past events.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
