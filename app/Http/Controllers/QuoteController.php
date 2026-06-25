<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\PriceBook;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteLineItem;
use Illuminate\Http\Request;
use App\Models\CrmSetting;


class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with(['account', 'opportunity'])
            ->latest()
            ->paginate(10);

        return view('quotes.index', compact('quotes'));
    }

    public function create(Request $request)
    {
        $settings = CrmSetting::current();
        $accounts = Account::orderBy('name')->get();
        $contacts = Contact::orderBy('last_name')->get();
        $opportunities = Opportunity::orderBy('name')->get();
        $priceBooks = PriceBook::where('is_active', true)->orderBy('name')->get();

        $selectedOpportunity = null;

        if ($request->filled('opportunity_id')) {
            $selectedOpportunity = Opportunity::with('account')
                ->find($request->integer('opportunity_id'));
        }

        return view('quotes.create', compact(
            'accounts',
            'contacts',
            'opportunities',
            'priceBooks',
            'selectedOpportunity',
            'settings'
        ));

    }

    public function store(Request $request)
    {
        $validated = $this->validateQuote($request);

        $validated['quote_number'] = Quote::nextQuoteNumber();

        Quote::create($validated);

        return redirect()
            ->route('quotes.index')
            ->with('success', 'Quote created successfully.');
    }

    public function show(Quote $quote)
    {
        $quote->load([
            'account',
            'contact',
            'opportunity',
            'priceBook',
            'lineItems.product',
        ]);

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        $settings = CrmSetting::current();

        return view('quotes.show', compact('quote', 'products', 'settings'));   
    }

    public function edit(Quote $quote)
    {
        $accounts = Account::orderBy('name')->get();
        $contacts = Contact::orderBy('last_name')->get();
        $opportunities = Opportunity::orderBy('name')->get();
        $priceBooks = PriceBook::where('is_active', true)->orderBy('name')->get();

        $settings = CrmSetting::current();

        return view('quotes.edit', compact(
            'quote',
            'accounts',
            'contacts',
            'opportunities',
            'priceBooks',
            'settings'
        ));
    }

    public function update(Request $request, Quote $quote)
    {
        $validated = $this->validateQuote($request);

        $quote->update($validated);

        return redirect()
            ->route('quotes.index')
            ->with('success', 'Quote updated successfully.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()
            ->route('quotes.index')
            ->with('success', 'Quote deleted successfully.');
    }

    public function addLineItem(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'product_id' => ['nullable', 'exists:products,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'tax_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        QuoteLineItem::create([
            'quote_id' => $quote->id,
            'product_id' => $validated['product_id'] ?? null,
            'product_name' => $validated['product_name'],
            'sku' => $validated['sku'] ?? null,
            'quantity' => $validated['quantity'],
            'unit_price' => $validated['unit_price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'tax_percent' => $validated['tax_percent'] ?? 0,
        ]);

        return back()->with('success', 'Quote line item added successfully.');
    }

    public function removeLineItem(QuoteLineItem $quoteLineItem)
    {
        $quoteLineItem->delete();

        return back()->with('success', 'Quote line item removed successfully.');
    }

    private function validateQuote(Request $request): array
    {
        return $request->validate([
            'opportunity_id' => ['nullable', 'exists:opportunities,id'],
            'account_id' => ['nullable', 'exists:accounts,id'],
            'contact_id' => ['nullable', 'exists:contacts,id'],
            'price_book_id' => ['nullable', 'exists:price_books,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'expiration_date' => ['nullable', 'date'],
            'terms' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
