<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\SalesOrderLineItem;
use App\Models\Quote;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::with(['account', 'quote'])
            ->latest()
            ->paginate(10);

        return view('sales_orders.index', compact('salesOrders'));
    }

    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load(['account', 'contact', 'quote', 'opportunity', 'lineItems']);

        $products = Product::where('is_active', true)->orderBy('name')->get();

        return view('sales_orders.show', compact('salesOrder', 'products'));
    }

    public function convertFromQuote(Quote $quote)
    {
        $quote->load('lineItems');

        $salesOrder = SalesOrder::create([
            'quote_id' => $quote->id,
            'opportunity_id' => $quote->opportunity_id,
            'account_id' => $quote->account_id,
            'contact_id' => $quote->contact_id,
            'order_number' => SalesOrder::nextOrderNumber(),
            'status' => 'Draft',
            'order_date' => now()->toDateString(),
            'subtotal' => $quote->subtotal,
            'discount_total' => $quote->discount_total,
            'tax_total' => $quote->tax_total,
            'grand_total' => $quote->grand_total,
            'notes' => 'Created from quote '.$quote->quote_number,
        ]);

        foreach ($quote->lineItems as $line) {
            SalesOrderLineItem::create([
                'sales_order_id' => $salesOrder->id,
                'product_id' => $line->product_id,
                'product_name' => $line->product_name,
                'sku' => $line->sku,
                'quantity' => $line->quantity,
                'unit_price' => $line->unit_price,
                'discount_percent' => $line->discount_percent,
                'tax_percent' => $line->tax_percent,
            ]);
        }

        $quote->update(['status' => 'Accepted']);

        return redirect()
            ->route('sales-orders.show', $salesOrder)
            ->with('success', 'Quote converted to sales order.');
    }
}
