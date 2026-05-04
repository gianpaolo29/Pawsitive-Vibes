<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = SupportTicket::with('user')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $tickets = $query->paginate(15);

        $counts = [
            'all' => SupportTicket::count(),
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('status', 'resolved')->count(),
            'rejected' => SupportTicket::where('status', 'rejected')->count(),
        ];

        return view('admin.tickets.index', compact('tickets', 'counts', 'status'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load('user');
        return view('admin.tickets.show', compact('ticket'));
    }

    public function approve(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'admin_remarks' => 'nullable|string|max:1000',
        ]);

        // Reactivate the user account
        if ($ticket->user) {
            $ticket->user->update([
                'is_active' => true,
                'blocked_reason' => null,
                'blocked_until' => null,
            ]);
        }

        $ticket->update([
            'status' => 'resolved',
            'admin_remarks' => $request->admin_remarks ?? 'Your account has been reactivated. You may now log in.',
            'resolved_at' => now(),
        ]);

        return redirect()->route('admin.tickets.index')
            ->with('success', "Ticket {$ticket->ticket_number} approved. Account has been reactivated.");
    }

    public function reject(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'admin_remarks' => 'required|string|max:1000',
        ]);

        $ticket->update([
            'status' => 'rejected',
            'admin_remarks' => $request->admin_remarks,
            'resolved_at' => now(),
        ]);

        return redirect()->route('admin.tickets.index')
            ->with('success', "Ticket {$ticket->ticket_number} has been rejected.");
    }

    public function markInProgress(SupportTicket $ticket)
    {
        $ticket->update(['status' => 'in_progress']);

        return back()->with('success', "Ticket {$ticket->ticket_number} marked as in progress.");
    }
}
