<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Quote;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $accounts = collect();
        $contacts = collect();
        $leads = collect();
        $opportunities = collect();
        $products = collect();
        $quotes = collect();
        $invoices = collect();
        $payments = collect();

        if ($search) {
            $accounts = Account::where('name', 'like', "%{$search}%")
                ->orWhere('industry', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $contacts = Contact::where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $leads = Lead::where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('company', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $opportunities = Opportunity::where('name', 'like', "%{$search}%")
                ->orWhere('stage', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $products = Product::where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $quotes = Quote::where('quote_number', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $invoices = Invoice::where('invoice_number', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            $payments = Payment::where('payment_number', 'like', "%{$search}%")
                ->orWhere('reference_number', 'like', "%{$search}%")
                ->orWhere('method', 'like', "%{$search}%")
                ->limit(10)
                ->get();
        }

        return view('search.index', compact(
            'search',
            'accounts',
            'contacts',
            'leads',
            'opportunities',
            'products',
            'quotes',
            'invoices',
            'payments'
        ));
    }
}
