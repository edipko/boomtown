<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventList extends Component
{
    public $events;
    public $displayCount = 4; // Initial number of events to display
    public $increment = 2; // Number of events to load each time "Show More" is clicked
    public $totalEvents; // Total number of upcoming events

    public function loadEvents()
    {
        // Count total upcoming events for "Show More" button
        $this->totalEvents = Event::where('date', '>=', now())->count();

        // Fetch only the number of events we want to display
        $this->events = Event::with('venue')
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take($this->displayCount)
            ->get();
    }

    public function showMore()
    {
        $this->displayCount += $this->increment;
        $this->loadEvents(); // Refresh events with the new display count
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
