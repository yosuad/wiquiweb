<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // ========= Guardar suscriptor (formulario público) =========
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create([
            'email' => $request->email,
            'origin' => 'wiquiweb.com',
            'status' => 'active',
        ]);

        return response()->json(['message' => '¡Gracias por suscribirte!']);
    }

    // ========= Página de baja (GET) =========
    public function unsubscribePage(Request $request)
    {
        $email = $request->query('email');
        $subscriber = $email ? Subscriber::where('email', $email)->first() : null;

        return view('site.unsubscribe', compact('email', 'subscriber'));
    }

    // ========= Procesar baja (POST) =========
    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ]);

        Subscriber::where('email', $request->email)
            ->update(['status' => 'unsubscribed']);

        return redirect()->route('subscribers.unsubscribe.page')->with('success', true);
    }
}
