<?php

namespace App\Console\Commands;

use App\Models\ContactService;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate-monthly';
    protected $description = 'Generate pending monthly invoices for all active services up to current month';

    public function handle()
    {
        $services = ContactService::where('billing_cycle', 'monthly')
            ->where('status', 'active')
            ->with(['invoices', 'contact'])
            ->get();

        $generated = 0;
        $now = Carbon::now()->startOfMonth();

        foreach ($services as $cs) {
            // Find the last invoiced month
            $lastInvoice = $cs->invoices
                ->filter(fn($i) => $i->period_start !== null)
                ->sortByDesc('period_start')
                ->first();

            // Start from the month after the last invoice, or from started_at
            if ($lastInvoice) {
                $next = Carbon::parse($lastInvoice->period_start)->addMonth()->startOfMonth();
            } else {
                $next = Carbon::parse($cs->started_at)->startOfMonth();
            }

            // Generate invoices month by month until current month
            while ($next->lte($now)) {
                // Check if invoice for this period already exists
                $exists = $cs->invoices->first(function($i) use ($next) {
                    return $i->period_start && Carbon::parse($i->period_start)->isSameMonth($next);
                });

                if (!$exists) {
                    Invoice::create([
                        'contact_service_id' => $cs->id,
                        'amount'             => $cs->price,
                        'created_by'         => 1, // system user
                        'status'             => 'pending',
                        'period_start'       => $next->copy()->startOfMonth(),
                        'period_end'         => $next->copy()->endOfMonth(),
                    ]);

                    $this->info("Generated invoice for {$cs->contact->first_name} {$cs->contact->last_name} — {$next->translatedFormat('F Y')}");
                    $generated++;
                }

                $next->addMonth();
            }
        }

        $this->info("Done. {$generated} invoice(s) generated.");

        return Command::SUCCESS;
    }
}