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
        $timezone = config('app.timezone'); // Get app's configured timezone
        $now = Carbon::now($timezone);
        $yesterday = Carbon::yesterday($timezone)->startOfDay();
        $endOfToday = $now->endOfDay(); // Ensure events until the end of today are included

        // Count total events from yesterday to end of today
        $this->totalEvents = Event::whereBetween('date', [$yesterday, $endOfToday])
            ->count();

        // Fetch only the number of events we want to display
        $this->events = Event::with('venue')
            ->whereBetween('date', [$yesterday, $endOfToday])
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

