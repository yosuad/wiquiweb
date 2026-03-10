<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactNote;
use Illuminate\Http\Request;

class ContactNoteController extends Controller
{
    // ========= View notes =========
    public function index(Contact $contact)
    {
        $notes = ContactNote::where('contact_id', $contact->id)
            ->with('author')
            ->latest()
            ->get();

        $from = request()->get('from');

        return view('admin.prospects.notes', compact('contact', 'notes', 'from'));
    }

    // ========= Store note =========
    public function store(Request $request, Contact $contact)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        ContactNote::create([
            'contact_id' => $contact->id,
            'created_by' => auth()->id(),
            'note'       => $request->note,
        ]);

        $from = $request->input('from');
        $url  = route('prospects.notes.index', $contact->id) . ($from ? '?from=' . $from : '');

        return redirect($url)->with('success', 'Note added successfully.');
    }


    // ========= Update note =========
    public function update(Request $request, Contact $contact, ContactNote $note)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        $note->update(['note' => $request->note]);

        $from = $request->input('from');
        $url  = route('prospects.notes.index', $contact->id) . ($from ? '?from=' . $from : '');

        return redirect($url)->with('success', 'Note updated successfully.');
    }


    // ========= Delete note =========
    public function destroy(Request $request, Contact $contact, ContactNote $note)
    {
        $note->delete();

        $from = $request->input('from');
        $url  = route('prospects.notes.index', $contact->id) . ($from ? '?from=' . $from : '');

        return redirect($url)->with('success', 'Note deleted successfully.');
    }
}