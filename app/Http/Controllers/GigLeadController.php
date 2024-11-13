<?php

// app/Http/Controllers/GigLeadController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GigLead;
use App\Notifications\NewGigLeadNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class GigLeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
        ]);

        $gigLead = GigLead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
        ]);

        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new NewGigLeadNotification($gigLead));

        return response()->json(['success' => true]);
    }

}

