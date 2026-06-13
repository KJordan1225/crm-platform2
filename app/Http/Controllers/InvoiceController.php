<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use App\Models\SalesOrder;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['account', 'salesOrder'])
            ->latest()
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['account', 'contact', 'salesOrder', 'quote', 'lineItems', 'payments']);

        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('invoices.show', compact('invoice', 'products'));
    }

    public function convertFromSalesOrder(SalesOrder $salesOrder)
    {
        $salesOrder->load('lineItems');

        $invoice = Invoice::create([
            'sales_order_id' => $salesOrder->id,
            'quote_id' => $salesOrder->quote_id,
            'account_id' => $salesOrder->account_id,
            'contact_id' => $salesOrder->contact_id,
            'invoice_number' => Invoice::nextInvoiceNumber(),
            'status' => 'Draft',
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(30)->toDateString(),
            'subtotal' => $salesOrder->subtotal,
            'discount_total' => $salesOrder->discount_total,
            'tax_total' => $salesOrder->tax_total,
            'grand_total' => $salesOrder->grand_total,
            'balance_due' => $salesOrder->grand_total,
            'notes' => 'Created from sales order '.$salesOrder->order_number,
        ]);

        foreach ($salesOrder->lineItems as $line) {
            InvoiceLineItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $line->product_id,
                'product_name' => $line->product_name,
                'sku' => $line->sku,
                'quantity' => $line->quantity,
                'unit_price' => $line->unit_price,
                'discount_percent' => $line->discount_percent,
                'tax_percent' => $line->tax_percent,
            ]);
        }

        $salesOrder->update(['status' => 'Invoiced']);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Sales order converted to invoice.');
    }
}
