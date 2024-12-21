<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class EventList extends Component
{
    public $events;
    public $displayCount = 5; // Initial number of events to display
    public $increment = 2; // Number of events to load each time "Show More" is clicked
    public $totalEvents; // Total number of events in the date range

    public function loadEvents()
    {
        $now = Carbon::now();
        $yesterday = Carbon::yesterday();

        // Count total events for "Show More" button
        $this->totalEvents = Event::whereBetween('date', [
            $yesterday->startOfDay(),
            $now->endOfDay()
        ])->count();

        // Fetch events within the range, limited by the display count
        $this->events = Event::with('venue')
            ->whereBetween('date', [
                $yesterday->startOfDay(),
                $now->endOfDay()
            ])
            ->orderBy('date', 'asc')
            ->take($this->displayCount)
            ->get();
    }

    public function showMore()
    {
        $this->displayCount += $this->increment;
        $this->loadEvents(); // Refresh events with the updated display count
    }

    public function mount()
    {
        $this->loadEvents();
    }

    public function render()
    {
        return view('livewire.event-list');
    }
}
