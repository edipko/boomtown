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

        // Remove any existing popup before adding a new one
        let existingPopup = document.getElementById("calendarPopup");
        if (existingPopup) {
            existingPopup.remove();
        }

        // Create popup outside of Livewire scope in <body>
        let popup = document.createElement('div');
        popup.id = "calendarPopup";
        popup.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.8); display: flex; align-items: center; justify-content: center; z-index: 99999;">
                <div style="background: #1a202c; color: white; padding: 20px; border-radius: 10px; text-align: center; max-width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                    <h2 style="font-size: 1.5rem; margin-bottom: 15px;">Add to Calendar</h2>
                    <p><a href="${googleCalendarUrl}" target="_blank" style="color: #3b82f6; text-decoration: none; font-size: 1.2rem;">📅 Google Calendar</a></p>
                    <p><a href="${icsUrl}" download="${title.replace(/\s+/g, '_')}.ics" style="color: #3b82f6; text-decoration: none; font-size: 1.2rem;">📅 Download ICS</a></p>
                    <button onclick="document.getElementById('calendarPopup').remove()" style="margin-top: 15px; background: #dc2626; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer;">Close</button>
                </div>
            </div>
        `;

        document.body.appendChild(popup);
    }
</script>


