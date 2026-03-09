<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProspectNote;
use Illuminate\Http\Request;

class ProspectNoteController extends Controller
{
    // ========= Ver notas =========
    public function index(User $prospect)
    {
        $notes = ProspectNote::where('user_id', $prospect->id)
            ->with('author')
            ->latest()
            ->get();

        $from = request()->get('from');

        return view('admin.prospects.notes', compact('prospect', 'notes', 'from'));
    }

    // ========= Guardar nota =========
    public function store(Request $request, User $prospect)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        ProspectNote::create([
            'user_id'    => $prospect->id,
            'created_by' => auth()->id(),
            'note'       => $request->note,
        ]);

        $from = $request->input('from');
        $url  = route('prospects.notes.index', $prospect->id) . ($from ? '?from=' . $from : '');

        return redirect($url)->with('success', 'Nota agregada correctamente.');
    }

    // ========= Eliminar nota =========
    public function destroy(Request $request, User $prospect, ProspectNote $note)
    {
        $note->delete();

        $from = $request->input('from');
        $url  = route('prospects.notes.index', $prospect->id) . ($from ? '?from=' . $from : '');

        return redirect($url)->with('success', 'Nota eliminada correctamente.');
    }
}