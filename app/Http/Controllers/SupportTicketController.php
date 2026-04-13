<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\User;
use App\Notifications\NewSupportTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SupportTicketController extends Controller
{
    public function create(Request $request)
    {
        $email = $request->query('email', '');
        return view('support.create', compact('email'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Check if the email belongs to an existing deactivated user
        $user = User::where('email', $request->email)
            ->where('is_active', false)
            ->first();

        if (!$user) {
            return back()->withInput()->withErrors([
                'email' => 'No deactivated account found with this email address.',
            ]);
        }

        // Check if there's already an open/in-progress ticket for this email
        $existingTicket = SupportTicket::where('email', $request->email)
            ->whereIn('status', ['open', 'in_progress'])
            ->first();

        if ($existingTicket) {
            return back()->withInput()->with('existing_ticket', $existingTicket->ticket_number);
        }

        $ticket = SupportTicket::create([
            'ticket_number' => SupportTicket::generateTicketNumber(),
            'user_id' => $user->id,
            'email' => $request->email,
            'name' => $request->name,
            'subject' => 'Account Reactivation Request',
            'message' => $request->message,
        ]);

        // Notify all admins
        $admins = User::where('role', 'ADMIN')->get();
        Notification::send($admins, new NewSupportTicketNotification($ticket));

        return redirect()->route('support.ticket.success', ['ticket' => $ticket->ticket_number]);
    }

    public function success(Request $request)
    {
        $ticketNumber = $request->query('ticket');
        return view('support.success', compact('ticketNumber'));
    }

    public function track(Request $request)
    {
        $ticket = null;
        $ticketNumber = $request->query('ticket');

        if ($ticketNumber) {
            $ticket = SupportTicket::where('ticket_number', $ticketNumber)->first();
        }

        return view('support.track', compact('ticket', 'ticketNumber'));
    }
}
