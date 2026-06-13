<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $pipelineValue = Opportunity::whereNotIn('stage', ['Closed Won', 'Closed Lost'])
            ->sum('amount');

        $closedWonValue = Opportunity::where('stage', 'Closed Won')
            ->sum('amount');

        $totalRevenue = Payment::sum('amount');

        $outstandingInvoices = Invoice::where('balance_due', '>', 0)
            ->sum('balance_due');

        $leadCount = Lead::count();

        $convertedLeadCount = Lead::where('status', 'Converted')->count();

        $conversionRate = $leadCount > 0
            ? ($convertedLeadCount / $leadCount) * 100
            : 0;

        $opportunitiesByStage = Opportunity::selectRaw('stage, COUNT(*) as total, SUM(amount) as value')
            ->groupBy('stage')
            ->get();

        $monthlyRevenue = Payment::selectRaw('YEAR(payment_date) as year, MONTH(payment_date) as month, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $agingInvoices = Invoice::where('balance_due', '>', 0)
            ->orderBy('due_date')
            ->get()
            ->map(function ($invoice) {
                $daysPastDue = $invoice->due_date
                    ? now()->diffInDays($invoice->due_date, false) * -1
                    : 0;

                return [
                    'invoice' => $invoice,
                    'days_past_due' => max(0, $daysPastDue),
                    'bucket' => $this->agingBucket(max(0, $daysPastDue)),
                ];
            });

        $topAccounts = Account::withSum('payments', 'amount')
            ->orderByDesc('payments_sum_amount')
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'pipelineValue',
            'closedWonValue',
            'totalRevenue',
            'outstandingInvoices',
            'leadCount',
            'convertedLeadCount',
            'conversionRate',
            'opportunitiesByStage',
            'monthlyRevenue',
            'agingInvoices',
            'topAccounts'
        ));
    }

    private function agingBucket(int $days): string
    {
        return match (true) {
            $days <= 0 => 'Current',
            $days <= 30 => '1-30 Days',
            $days <= 60 => '31-60 Days',
            $days <= 90 => '61-90 Days',
            default => '90+ Days',
        };
    }
}
