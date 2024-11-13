<div class="bg-gray-800 bg-opacity-75 p-10 rounded-lg shadow-lg text-white">
    <h2 class="text-3xl font-semibold text-center mb-6">Upcoming Events</h2>

    @if($events->isEmpty())
        <p class="text-center">No upcoming events. Check back soon!</p>
    @else
        <div class="space-y-1">
            @foreach($events as $event)
                <div class="relative">
                    <div class="flex items-center bg-gray-900 bg-opacity-80 rounded-lg p-2 shadow-md border-2 border-black relative">
                        <div class="flex-shrink-0 w-20 h-20 border-2 border-blue-300 rounded-full flex flex-col items-center justify-center text-center text-blue-300 font-bold">
                            <span class="text-sm">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                            <span class="text-2xl">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                            <span class="text-sm">{{ \Carbon\Carbon::parse($event->date)->format('D') }}</span>
                        </div>

                        <!-- Event Details with Tooltip -->
                        <div class="ml-3 space-y-0.5">
                            <div class="relative group" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
                                <span class="text-lg font-bold text-blue-300 hover:text-blue-200 cursor-pointer">
                                    {{ $event->venue->name }}
                                </span>

                                <div x-show="show" x-transition class="absolute left-0 mt-2 w-64 p-4 bg-gray-800 text-white rounded-lg shadow-lg z-50">
                                    <h3 class="text-lg font-bold">{{ $event->venue->name }}</h3>
                                    <p class="text-sm"><strong>Address:</strong> {{ $event->venue->address }}, {{ $event->venue->city }}, {{ $event->venue->state }} {{ $event->venue->zip }}</p>
                                    <p class="text-sm"><strong>Telephone:</strong> {{ $event->venue->telephone }}</p>
                                </div>
                            </div>

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
