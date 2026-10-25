<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    // ========= Lista de suscriptores =========
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $subscribers = Subscriber::query()
            ->when($search, fn ($q) => $q->where('email', 'like', "%$search%"))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        $total = Subscriber::count();
        $active = Subscriber::where('status', 'active')->count();
        $unsubscribed = Subscriber::where('status', 'unsubscribed')->count();

        return view('admin.subscribers.index', compact(
            'subscribers',
            'search',
            'status',
            'total',
            'active',
            'unsubscribed'
        ));
    }

    // ========= Exportar CSV =========
    public function export(Request $request)
    {
        $status = $request->input('status');

        $subscribers = Subscriber::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->get();

        $filename = 'suscriptores';
        if ($status) {
            $filename .= '_'.$status;
        }
        $filename .= '_'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($subscribers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Email', 'Origin', 'Status', 'Fecha']);
            foreach ($subscribers as $subscriber) {
                fputcsv($file, [
                    $subscriber->email,
                    $subscriber->origin,
                    $subscriber->status,
                    $subscriber->created_at->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ========= Eliminar suscriptor =========
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('subscribers.index')->with('success', 'Suscriptor eliminado.');
    }
}
