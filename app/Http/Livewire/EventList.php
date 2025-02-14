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
        $timezone = config('app.timezone'); // Ensure consistency with Laravel's timezone setting
        $yesterdayStart = Carbon::yesterday($timezone)->startOfDay();
        $todayEnd = Carbon::today($timezone)->endOfDay();

        // Count total events from yesterday to today
        $this->totalEvents = Event::where('date', '>=', $yesterdayStart)
            ->where('date', '<=', $todayEnd)
            ->count();

        // Fetch only the number of events we want to display
        $this->events = Event::with('venue')
            ->where('date', '>=', $yesterdayStart)
            ->where('date', '<=', $todayEnd)
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

