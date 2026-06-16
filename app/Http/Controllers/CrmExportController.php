<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Payment;
use App\Models\Quote;
use Illuminate\Http\Response;


class CrmExportController extends Controller
{
    public function accounts()
    {
        return $this->downloadCsv('accounts.csv', [
            'ID', 'Name', 'Industry', 'Website', 'Phone', 'Email', 'Created At',
        ], Account::all()->map(fn ($account) => [
            $account->id,
            $account->name,
            $account->industry,
            $account->website,
            $account->phone,
            $account->email,
            $account->created_at,
        ]));
    }

    public function contacts()
    {
        return $this->downloadCsv('contacts.csv', [
            'ID', 'Account', 'First Name', 'Last Name', 'Title', 'Email', 'Phone', 'Mobile',
        ], Contact::with('account')->get()->map(fn ($contact) => [
            $contact->id,
            $contact->account?->name,
            $contact->first_name,
            $contact->last_name,
            $contact->title,
            $contact->email,
            $contact->phone,
            $contact->mobile,
        ]));
    }

    public function leads()
    {
        return $this->downloadCsv('leads.csv', [
            'ID', 'Company', 'First Name', 'Last Name', 'Email', 'Phone', 'Status', 'Source', 'Estimated Value',
        ], Lead::all()->map(fn ($lead) => [
            $lead->id,
            $lead->company,
            $lead->first_name,
            $lead->last_name,
            $lead->email,
            $lead->phone,
            $lead->status,
            $lead->source,
            $lead->estimated_value,
        ]));
    }

    public function opportunities()
    {
        return $this->downloadCsv('opportunities.csv', [
            'ID', 'Account', 'Name', 'Amount', 'Stage', 'Probability', 'Close Date', 'Source',
        ], Opportunity::with('account')->get()->map(fn ($opportunity) => [
            $opportunity->id,
            $opportunity->account?->name,
            $opportunity->name,
            $opportunity->amount,
            $opportunity->stage,
            $opportunity->probability,
            $opportunity->close_date,
            $opportunity->source,
        ]));
    }

    public function quotes()
    {
        return $this->downloadCsv('quotes.csv', [
            'ID', 'Quote Number', 'Name', 'Account', 'Status', 'Subtotal', 'Tax', 'Grand Total',
        ], Quote::with('account')->get()->map(fn ($quote) => [
            $quote->id,
            $quote->quote_number,
            $quote->name,
            $quote->account?->name,
            $quote->status,
            $quote->subtotal,
            $quote->tax_total,
            $quote->grand_total,
        ]));
    }

    public function invoices()
    {
        return $this->downloadCsv('invoices.csv', [
            'ID', 'Invoice Number', 'Account', 'Status', 'Grand Total', 'Paid', 'Balance Due',
        ], Invoice::with('account')->get()->map(fn ($invoice) => [
            $invoice->id,
            $invoice->invoice_number,
            $invoice->account?->name,
            $invoice->status,
            $invoice->grand_total,
            $invoice->amount_paid,
            $invoice->balance_due,
        ]));
    }

    public function payments()
    {
        return $this->downloadCsv('payments.csv', [
            'ID', 'Payment Number', 'Invoice', 'Account', 'Date', 'Amount', 'Method', 'Reference',
        ], Payment::with(['invoice', 'account'])->get()->map(fn ($payment) => [
            $payment->id,
            $payment->payment_number,
            $payment->invoice?->invoice_number,
            $payment->account?->name,
            $payment->payment_date,
            $payment->amount,
            $payment->method,
            $payment->reference_number,
        ]));
    }

    private function downloadCsv(string $filename, array $headers, $rows)
    {
        $callback = function () use ($headers, $rows) {
            $file = fopen('php://output', 'w');

            fputcsv($file, $headers);

            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
