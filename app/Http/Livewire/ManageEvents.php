<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class ManageEvents extends Component
{
    public $upcomingEvents;
    public $pastEvents;

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $today = Carbon::today()->toDateString();

        // Upcoming Events (today and future)
        $this->upcomingEvents = Event::with('venue')
            ->whereDate('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->get();

        // Past Events (before today)
        $this->pastEvents = Event::with('venue')
            ->whereDate('date', '<', $today)
            ->orderBy('date', 'desc')
            ->get();
    }


    public function deleteEvent($eventId)
    {
        Event::find($eventId)?->delete();
        $this->loadEvents(); // Refresh lists after deletion
    }

    public function render()
    {
        return view('livewire.manage-events');
    }
}

?>
