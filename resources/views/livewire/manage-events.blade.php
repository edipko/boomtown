<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Events</h1>
        <div class="flex space-x-4">
            <!-- Add New Event Button -->
            <a href="{{ route('events.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Add New Event
            </a>

            <!-- Copy Event List Button (Now Visible) -->
            <button onclick="showEventList()"
                    class="bg-green-500 hover:bg-green-600 text-black font-bold py-2 px-4 rounded">
                📋 Copy Event List
            </button>
        </div>
    </div>

    <!-- Popup for Event List -->
    <div id="eventListPopup" class="hidden fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center">
        <div class="bg-gray-900 text-white rounded-lg p-6 shadow-lg w-full max-w-3xl h-auto max-h-[80vh] overflow-auto">
            <h2 class="text-xl font-semibold mb-4 text-white">Event List</h2>
            <textarea id="eventListText" class="w-full h-48 p-3 border rounded text-black"></textarea>
            <div class="flex justify-end mt-4 space-x-4">
                <!-- Copy to Clipboard Button (Now Visible) -->
                <button onclick="copyEventList()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Copy to Clipboard
                </button>
                <!-- Close Button (Now Visible) -->
                <button onclick="closePopup()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </div>
    </div>

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
                    <td class="p-3">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</td>
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

</div>

<!-- JavaScript for Popup & Copy Functionality -->
<script>
    function showEventList() {
        let events = @json($upcomingEvents);
        let eventText = "";

        events.forEach(event => {
            let eventDate = new Date(event.date);
            let formattedDate = eventDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            let formattedTime = new Date("1970-01-01T" + event.time).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

            eventText += formattedDate + " - " + formattedTime + " - " + event.venue.name + "\\n";
        });

        // Set the text in the textarea
        let eventTextArea = document.getElementById("eventListText");
        eventTextArea.value = eventText.replace(/\\n/g, '\n'); // Ensure line breaks work properly
        document.getElementById("eventListPopup").classList.remove("hidden");
    }

    function copyEventList() {
        let copyText = document.getElementById("eventListText");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Event list copied to clipboard!");
    }

    function closePopup() {
        document.getElementById("eventListPopup").classList.add("hidden");
    }
</script>
