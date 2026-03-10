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
        // ─── Goals configuration ──────────────────────────────────────────────
        $metaVentasPorVendedor   = config('settings.meta_ventas_por_vendedor', 600);
        $metaClientesPorVendedor = config('settings.meta_clientes_por_vendedor', 1);
        $totalVendedores         = User::role('sales-agent')->count();
        $metaVentas              = $totalVendedores * $metaVentasPorVendedor;
        $metaClientes            = $totalVendedores * $metaClientesPorVendedor;

        // ─── Row 1 ────────────────────────────────────────────────────────────
        $totalProspects = Contact::where('status', 'prospect')->count();

        $newCustomersThisMonth = Contact::where('status', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $monthlyRevenue = Invoice::whereIn('status', ['paid', 'approved'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $totalServices = Service::count();

        // ─── Row 2 ────────────────────────────────────────────────────────────
        $totalStaff = User::role(['administrator', 'agent', 'sales-agent', 'billing-agent', 'support'])->count();
        $totalSupports   = SupportTicket::whereIn('status', ['open', 'in_progress'])->count();
        $totalVendedores = User::role('sales-agent')->count();
        $totalCustomers  = Contact::where('status', 'customer')->count();

        // ─── Percentages vs goals ─────────────────────────────────────────────
        $revenuePercent   = $metaVentas   > 0 ? min(100, round(($monthlyRevenue        / $metaVentas)   * 100)) : 0;
        $customersPercent = $metaClientes > 0 ? min(100, round(($newCustomersThisMonth / $metaClientes) * 100)) : 0;

        // ─── Recent activity ──────────────────────────────────────────────────
        $recentProspects = Contact::where('status', 'prospect')
            ->latest()
            ->take(5)
            ->get();

        // ─── Pending invoices ─────────────────────────────────────────────────
        $pendingInvoices = Invoice::with(['contactService.contact'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $totalPending = Invoice::where('status', 'pending')->sum('amount');

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
            'totalPending'
        ));
    }
}