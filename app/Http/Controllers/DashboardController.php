<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\SupportTicket;

class DashboardController extends Controller
{
    public function index()
    {
        $user          = auth()->user();
        $isAdmin       = $user->hasRole('administrator');
        $isBilling     = $user->hasRole('billing-agent');
        $isSupport     = $user->hasRole('support');

        // ─── Goals configuration ──────────────────────────────────────────────
        $metaVentasPorVendedor   = config('settings.meta_ventas_por_vendedor', 600);
        $metaClientesPorVendedor = config('settings.meta_clientes_por_vendedor', 1);
        $totalVendedores         = User::role('sales-agent')->count();
        $metaVentas              = $isAdmin ? $totalVendedores * $metaVentasPorVendedor : $metaVentasPorVendedor;
        $metaClientes            = $isAdmin ? $totalVendedores * $metaClientesPorVendedor : $metaClientesPorVendedor;

        // ─── Scope base por rol ───────────────────────────────────────────────
        // administrator ve todo, el resto ve solo sus asignados
        $contactScope = Contact::when(!$isAdmin, fn($q) => $q->where('assigned_to', $user->id));

        // ─── Row 1 ────────────────────────────────────────────────────────────
        $totalProspects = (clone $contactScope)->where('status', 'prospect')->count();

        $newCustomersThisMonth = (clone $contactScope)
            ->where('status', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Facturación — billing-agent y admin ven todo, agentes ven sus clientes
        $monthlyRevenue = Invoice::whereIn('status', ['paid', 'approved'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->when(!$isAdmin && !$isBilling, function($q) use ($user) {
                $q->whereHas('contactService.contact', fn($q2) => $q2->where('assigned_to', $user->id));
            })
            ->sum('amount');

        $totalServices = Service::count();

        // ─── Row 2 ────────────────────────────────────────────────────────────
        $totalStaff    = $isAdmin ? User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])->count() : null;

        $totalSupports = SupportTicket::whereIn('status', ['open', 'in_progress'])
            ->when(!$isAdmin, fn($q) => $q->where('assigned_to', $user->id))
            ->count();

        $totalCustomers = (clone $contactScope)->where('status', 'customer')->count();

        // ─── Percentages vs goals ─────────────────────────────────────────────
        $revenuePercent   = $metaVentas   > 0 ? min(100, round(($monthlyRevenue        / $metaVentas)   * 100)) : 0;
        $customersPercent = $metaClientes > 0 ? min(100, round(($newCustomersThisMonth / $metaClientes) * 100)) : 0;

        // ─── Recent activity ──────────────────────────────────────────────────
        $recentProspects = (clone $contactScope)
            ->where('status', 'prospect')
            ->latest()
            ->take(5)
            ->get();

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
            'recentProspects',
            'pendingInvoices',
            'totalPending',
            'isAdmin',
            'isBilling',
            'isSupport'
        ));
    }
}