<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_id',
        'quote_id',
        'account_id',
        'contact_id',
        'invoice_number',
        'status',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount_total',
        'tax_total',
        'grand_total',
        'amount_paid',
        'balance_due',
        'terms',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function lineItems()
    {
        return $this->hasMany(InvoiceLineItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function nextInvoiceNumber(): string
    {
        $nextId = (int) static::max('id') + 1;

        return 'INV-' . str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
    }

    public function recalculateTotals(): void
    {
        $this->loadMissing(['lineItems', 'payments']);

        $subtotal = $this->lineItems->sum(fn ($line) => $line->quantity * $line->unit_price);

        $discountTotal = $this->lineItems->sum(function ($line) {
            $base = $line->quantity * $line->unit_price;
            return $base * ($line->discount_percent / 100);
        });

        $taxTotal = $this->lineItems->sum(function ($line) {
            $base = $line->quantity * $line->unit_price;
            $discount = $base * ($line->discount_percent / 100);
            return ($base - $discount) * ($line->tax_percent / 100);
        });

        $grandTotal = $subtotal - $discountTotal + $taxTotal;
        $amountPaid = $this->payments->sum('amount');
        $balanceDue = $grandTotal - $amountPaid;

        $status = $this->status;

        if ($balanceDue <= 0 && $grandTotal > 0) {
            $status = 'Paid';
        } elseif ($amountPaid > 0 && $balanceDue > 0) {
            $status = 'Partially Paid';
        }

        $this->update([
            'subtotal' => $subtotal,
            'discount_total' => $discountTotal,
            'tax_total' => $taxTotal,
            'grand_total' => $grandTotal,
            'amount_paid' => $amountPaid,
            'balance_due' => $balanceDue,
            'status' => $status,
        ]);
    }
}
