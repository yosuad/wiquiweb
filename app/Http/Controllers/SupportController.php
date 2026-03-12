<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportTicketNote;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    // ========= List tickets =========
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $status   = $request->input('status');
        $priority = $request->input('priority');

        $tickets = SupportTicket::with(['contact', 'agent', 'creator'])
            ->when($search, function($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                  ->orWhereHas('contact', function($q2) use ($search) {
                      $q2->where('first_name', 'like', "%$search%")
                         ->orWhere('last_name', 'like', "%$search%")
                         ->orWhere('company_name', 'like', "%$search%");
                  });
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($priority, fn($q) => $q->where('priority', $priority))
            ->orderByRaw("FIELD(status, 'open', 'in_progress', 'resolved', 'closed')")
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->latest()
            ->paginate(15);

        return view('admin.support', compact('tickets', 'search', 'status', 'priority'));
    }

    // ========= Show ticket =========
    public function show(SupportTicket $ticket)
    {
        $ticket->load(['contact', 'agent', 'creator', 'notes.creator']);
        $agents = User::role(['administrator', 'agent', 'sales-agent'])->get();
        return view('admin.support.show', compact('ticket', 'agents'));
    }

    // ========= Create form =========
    public function create()
    {
        $contacts = Contact::where('status', 'customer')->orderBy('first_name')->get();
        $agents   = User::role(['administrator', 'agent', 'sales-agent'])->get();
        return view('admin.support.create', compact('contacts', 'agents'));
    }

    // ========= Store ticket =========
    public function store(Request $request)
    {
        $request->validate([
            'contact_id'  => 'required|exists:contacts,id',
            'subject'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        SupportTicket::create([
            'contact_id'  => $request->contact_id,
            'created_by'  => auth()->id(),
            'assigned_to' => $request->assigned_to,
            'subject'     => $request->subject,
            'description' => $request->description,
            'priority'    => $request->priority,
            'status'      => 'open',
        ]);

        return redirect()->route('support')->with('success', 'Ticket created successfully.');
    }

    // ========= Update ticket =========
    public function update(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status'      => 'required|in:open,in_progress,resolved,closed',
            'priority'    => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);

        $ticket->update([
            'status'      => $request->status,
            'priority'    => $request->priority,
            'assigned_to' => $request->assigned_to,
            'description' => $request->description,
            'resolved_at' => in_array($request->status, ['resolved', 'closed']) ? now() : null,
        ]);

        return redirect()->route('support.show', $ticket->id)->with('success', 'Ticket updated successfully.');
    }

    // ========= Delete ticket =========
    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();
        return redirect()->route('support')->with('success', 'Ticket deleted successfully.');
    }

    // ========= Store note =========
    public function storeNote(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        SupportTicketNote::create([
            'ticket_id'  => $ticket->id,
            'created_by' => auth()->id(),
            'note'       => $request->note,
        ]);

        return redirect()->route('support.show', $ticket->id)->with('success', 'Note added.');
    }

    // ========= Delete note =========
    public function destroyNote(SupportTicket $ticket, SupportTicketNote $note)
    {
        $note->delete();
        return redirect()->route('support.show', $ticket->id)->with('success', 'Note deleted.');
    }
}