<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\ContactLog;
use App\Models\ContactService;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\SupportTicket;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user      = auth()->user();
        $isAdmin   = $user->hasRole('administrator');
        $isBilling = $user->hasRole('billing-agent');
        $isSupport = $user->hasRole('support');

        // ─── Goals configuration ──────────────────────────────────────────────
        $metaVentasPorVendedor   = config('settings.meta_ventas_por_vendedor', 600);
        $metaClientesPorVendedor = config('settings.meta_clientes_por_vendedor', 1);
        $metaMensualidades       = config('settings.meta_mensualidades_negocio', 30);
        $totalVendedores         = User::role('sales-agent')->count();
        $metaVentas              = $isAdmin ? $totalVendedores * $metaVentasPorVendedor : $metaVentasPorVendedor;
        $metaClientes            = $isAdmin ? $totalVendedores * $metaClientesPorVendedor : $metaClientesPorVendedor;

        // ─── Scope base por rol ───────────────────────────────────────────────
        $contactScope = Contact::when(!$isAdmin, fn($q) => $q->where('assigned_to', $user->id));

        // ─── Row 1 ────────────────────────────────────────────────────────────
        $totalProspects = (clone $contactScope)->where('status', 'prospect')->count();

        $newCustomersThisMonth = (clone $contactScope)
            ->where('status', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $monthlyRevenue = Invoice::whereIn('status', ['paid', 'approved'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->when(!$isAdmin && !$isBilling, function($q) use ($user) {
                $q->whereHas('contactService.contact', fn($q2) => $q2->where('assigned_to', $user->id));
            })
            ->sum('amount');

        $totalServices = Service::count();

        // ─── Row 2 ────────────────────────────────────────────────────────────
        $totalStaff = $isAdmin
            ? User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])->count()
            : null;

        $totalSupports = SupportTicket::whereIn('status', ['open', 'in_progress'])
            ->when(!$isAdmin, fn($q) => $q->where('assigned_to', $user->id))
            ->count();

        $totalCustomers = (clone $contactScope)->where('status', 'customer')->count();

        // ─── Percentages vs goals ─────────────────────────────────────────────
        $revenuePercent   = $metaVentas   > 0 ? min(100, round(($monthlyRevenue        / $metaVentas)   * 100)) : 0;
        $customersPercent = $metaClientes > 0 ? min(100, round(($newCustomersThisMonth / $metaClientes) * 100)) : 0;

        // ─── Mensualidades activas del negocio (meta fija) ────────────────────
        $mensualidadesActivas = ContactService::where('status', 'active')
            ->where('billing_cycle', 'monthly')
            ->count();

        $mensualidadesPercent = $metaMensualidades > 0
            ? min(100, round(($mensualidadesActivas / $metaMensualidades) * 100))
            : 0;

        // ─── Recent activity ──────────────────────────────────────────────────
        $recentActivity = ContactLog::with(['contact', 'author'])
            ->whereIn('type', ['status_change', 'assignment_change'])
            ->when(!$isAdmin, function($q) use ($user) {
                $q->where('created_by', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // ─── My conversions ───────────────────────────────────────────────────
        $myConversions = !$isAdmin
            ? Contact::where('assigned_to', $user->id)
                ->where('status', 'customer')
                ->latest()
                ->take(10)
                ->get()
            : collect();

        // ─── Pending invoices ─────────────────────────────────────────────────
        $pendingInvoices = Invoice::with(['contactService.contact'])
            ->where('status', 'pending')
            ->when(!$isAdmin && !$isBilling, function($q) use ($user) {
                $q->whereHas('contactService.contact', fn($q2) => $q2->where('assigned_to', $user->id));
            })
            ->latest()
            ->take(5)
            ->get();

        $totalPending = Invoice::where('status', 'pending')
            ->when(!$isAdmin && !$isBilling, function($q) use ($user) {
                $q->whereHas('contactService.contact', fn($q2) => $q2->where('assigned_to', $user->id));
            })
            ->sum('amount');

        // ─── Site settings (solo administrator) ───────────────────────────────
        $settings = [];
        if ($isAdmin) {
            $settings = [
                'fecha_inicio'          => Setting::get('fecha_inicio', '2021-12-02'),
                'proyectos_realizados'  => (int) Setting::get('proyectos_realizados', 11),
            ];
        }

        return view('admin.dashboard', compact(
            'totalProspects',
            'totalCustomers',
            'totalServices',
            'totalStaff',
            'totalSupports',
            'totalVendedores',
            'monthlyRevenue',
            'newCustomersThisMonth',
            'revenuePercent',
            'customersPercent',
            'metaVentas',
            'metaClientes',
            'metaMensualidades',
            'mensualidadesActivas',
            'mensualidadesPercent',
            'recentActivity',
            'myConversions',
            'pendingInvoices',
            'totalPending',
            'isAdmin',
            'isBilling',
            'isSupport',
            'settings'
        ));
    }

    // ─── Update site settings ─────────────────────────────────────────────────
    public function updateSettings(Request $request)
    {        
        $request->validate([
            'fecha_inicio'         => 'nullable|date',
            'proyectos_realizados' => 'required|integer|min:0',
        ]);

        // Guardar proyectos realizados
        Setting::updateOrCreate(
            ['key' => 'proyectos_realizados'],
            ['value' => $request->proyectos_realizados]
        );

        // Guardar fecha_inicio solo si viene en el request
        if ($request->filled('fecha_inicio')) {
            Setting::updateOrCreate(
                ['key' => 'fecha_inicio'],
                ['value' => $request->fecha_inicio]
            );
        }

        return redirect()->route('dashboard')->with('success', 'Settings updated successfully.');
    }
}