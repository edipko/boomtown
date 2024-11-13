<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailingList;
use Illuminate\Support\Facades\Mail;

class MailingListController extends Controller
{
    public function index()
    {
        $users = MailingList::all();
        return view('dashboard.mailing-list.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = MailingList::findOrFail($id);
        $user->delete();
        return redirect()->route('mailing-list.index')->with('success', 'User removed from the mailing list.');
    }

    public function sendEmails(Request $request)
    {
        $users = MailingList::all();
        $subject = $request->subject;
        $messageBody = $request->message;

        foreach ($users as $user) {
            Mail::raw($messageBody, function ($message) use ($user, $subject) {
                $message->to($user->email);
                $message->subject($subject);
            });
        }

        return redirect()->route('mailing-list.index')->with('success', 'Emails sent successfully.');
    }
}
