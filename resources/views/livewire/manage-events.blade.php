<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Events</h1>

    <!-- Upcoming Events -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-green-700">Upcoming Events</h2>

        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-gray-200 text-gray-700 text-sm uppercase">
                <th class="border p-3 text-left">Event Name</th>
                <th class="border p-3 text-left">Date</th>
                <th class="border p-3 text-left">Time</th>
                <th class="border p-3 text-left">Venue</th>
                <th class="border p-3 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($upcomingEvents as $event)
                <tr class="border-b bg-white hover:bg-gray-100 transition">
                    <td class="p-3">{{ $event->name }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                    <td class="p-3">{{ $event->time }}</td>
                    <td class="p-3">{{ $event->venue->name }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        |
                        <button wire:click="deleteEvent({{ $event->id }})"
                                class="text-red-600 hover:underline">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-3 text-gray-500">No upcoming events.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Past Events -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Past Events</h2>

        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-gray-200 text-gray-700 text-sm uppercase">
                <th class="border p-3 text-left">Event Name</th>
                <th class="border p-3 text-left">Date</th>
                <th class="border p-3 text-left">Time</th>
                <th class="border p-3 text-left">Venue</th>
                <th class="border p-3 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($pastEvents as $event)
                <tr class="border-b bg-gray-50 hover:bg-gray-200 transition">
                    <td class="p-3 text-gray-500">{{ $event->name }}</td>
                    <td class="p-3 text-gray-500">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                    <td class="p-3 text-gray-500">{{ $event->time }}</td>
                    <td class="p-3 text-gray-500">{{ $event->venue->name }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        |
                        <button wire:click="deleteEvent({{ $event->id }})"
                                class="text-red-600 hover:underline">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-3 text-gray-500">No past events.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
