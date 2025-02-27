<div class="bg-gray-800 bg-opacity-75 p-10 rounded-lg shadow-lg text-white">
    <h2 class="text-3xl font-semibold text-center mb-6">Upcoming Events</h2>

    @if($events->isEmpty())
        <p class="text-center">No upcoming events. Check back soon!</p>
    @else
        <div class="space-y-1">
            @foreach($events as $event)
                <div class="relative">
                    <div class="flex items-center bg-gray-900 bg-opacity-80 rounded-lg p-2 shadow-md border-2 border-black relative">

                        <!-- DATE CIRCLE -->
                        <div class="flex flex-col items-center">
                            <div class="flex-shrink-0 w-20 h-20 border-2 border-blue-300 rounded-full flex flex-col items-center justify-center text-center text-blue-300 font-bold">
                                <span class="text-sm">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                                <span class="text-2xl">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($event->date)->format('D') }}</span>
                            </div>

                            <!-- 📅 Add to Calendar Link BELOW the Circle -->
                            <a href="#" onclick="addToCalendar(event, '{{ $event->name }}', '{{ $event->venue->name }}', '{{ $event->date }}', '{{ $event->time }}')"
                               class="text-blue-400 hover:text-blue-300 text-sm mt-2">
                                📅 Add
                            </a>
                        </div>

                        <!-- EVENT DETAILS -->
                        <div class="ml-3 space-y-0.5">
                            <span class="text-lg font-bold text-blue-300">
                                {{ $event->venue->name }}
                            </span>
                            <p class="text-blue-300 text-sm">{{ $event->venue->city }}, {{ $event->venue->state }}</p>
                            <p class="text-xl font-bold text-white">{{ $event->name }}</p>
                            <p class="text-sm text-gray-400 uppercase">
                                SHOW TIME: <span class="text-blue-300">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                            </p>
                            <p class="text-sm text-gray-400 uppercase">
                                COVER CHARGE:
                                <span class="text-blue-300">{{ $event->admission_cost == 0 ? 'No Cover' : '$' . number_format($event->admission_cost, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($displayCount < $totalEvents)
            <button wire:click="showMore" class="mt-4 text-white underline hover:text-blue-300">
                Show More Events
            </button>
        @endif
    @endif
</div>

<!-- JavaScript for Add to Calendar Functionality -->
<script>
    function addToCalendar(event, title, location, date, time) {
        event.preventDefault();

        let startDateTime = new Date(`${date}T${time}`);
        let endDateTime = new Date(startDateTime.getTime() + (2 * 60 * 60 * 1000)); // 2-hour event

        let formattedStart = startDateTime.toISOString().replace(/-|:|\.\d+/g, '');
        let formattedEnd = endDateTime.toISOString().replace(/-|:|\.\d+/g, '');

        let description = "Join us for this event at " + location;

        // Generate Google Calendar Link
        let googleCalendarUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${formattedStart}/${formattedEnd}&location=${encodeURIComponent(location)}&details=${encodeURIComponent(description)}&sf=true&output=xml`;

        // Generate .ICS file for Outlook/Apple Calendar
        let icsContent = `BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
SUMMARY:${title}
LOCATION:${location}
DTSTART:${formattedStart}
DTEND:${formattedEnd}
DESCRIPTION:${description}
END:VEVENT
END:VCALENDAR`;

        let blob = new Blob([icsContent], { type: 'text/calendar' });
        let icsUrl = URL.createObjectURL(blob);

        // Display calendar options
        let popup = document.createElement('div');
        popup.innerHTML = `<div class="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center">
            <div class="bg-gray-900 text-white rounded-lg p-6 shadow-lg w-full max-w-md text-center">
                <h2 class="text-xl font-semibold mb-4">Add to Calendar</h2>
                <p><a href="${googleCalendarUrl}" target="_blank" class="text-blue-400 hover:underline">📅 Google Calendar</a></p>
                <p><a href="${icsUrl}" download="${title.replace(/\s+/g, '_')}.ics" class="text-blue-400 hover:underline">📅 Download ICS</a></p>
                <button onclick="this.parentElement.parentElement.remove()" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>`;

        document.body.appendChild(popup);
    }
</script>
