<?php
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewGigLeadNotification;

class GigLeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
        ]);

        // Store gig lead information
        $gigLead = GigLead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
        ]);

        // Notify all users
        $users = User::all();
        Notification::send($users, new NewGigLeadNotification($gigLead));

        return redirect()->back()->with('status', 'Your booking request has been received! We will contact you soon.');
    }
}
