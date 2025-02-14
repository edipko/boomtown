<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class EventList extends Component
{
    public $events;
    public $displayCount = 4; // Initial number of events to display
    public $increment = 2; // Number of events to load each time "Show More" is clicked
    public $totalEvents; // Total number of upcoming events

    public function loadEvents()
    {
        $now = Carbon::now();
        $yesterday = Carbon::yesterday()->toDateString();
        $today = Carbon::today()->toDateString();

        // Count total events from yesterday through future dates
        $this->totalEvents = Event::whereDate('date', '>=', $yesterday)->count();

        // Fetch only the number of events we want to display
        $this->events = Event::with('venue')
            ->whereDate('date', '>=', $yesterday) // Include yesterday, today, and future dates
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


?>

