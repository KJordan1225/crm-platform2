<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CrmTaskController;
use App\Http\Controllers\CrmNoteController;
use App\Http\Controllers\CrmActivityController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignMemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PriceBookController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('accounts', AccountController::class);
    Route::resource('contacts', ContactController::class);
    Route::post('/leads/{lead}/convert', [LeadController::class, 'convert'])
        ->name('leads.convert');
    Route::resource('leads', LeadController::class);
    Route::resource('opportunities', OpportunityController::class);   
    Route::post('/crm-tasks/{crmTask}/complete', [CrmTaskController::class, 'complete'])
    ->name('crm-tasks.complete');

    Route::resource('crm-tasks', CrmTaskController::class);

    Route::post('/crm-notes', [CrmNoteController::class, 'store'])
        ->name('crm-notes.store');

    Route::delete('/crm-notes/{crmNote}', [CrmNoteController::class, 'destroy'])
        ->name('crm-notes.destroy');

    Route::post('/crm-activities', [CrmActivityController::class, 'store'])
        ->name('crm-activities.store');

    Route::delete('/crm-activities/{crmActivity}', [CrmActivityController::class, 'destroy'])
        ->name('crm-activities.destroy');

    Route::resource('campaigns', CampaignController::class);

    Route::post('/campaigns/{campaign}/members', [CampaignMemberController::class, 'store'])
        ->name('campaign-members.store');

    Route::put('/campaign-members/{campaignMember}', [CampaignMemberController::class, 'update'])
        ->name('campaign-members.update');

    Route::delete('/campaign-members/{campaignMember}', [CampaignMemberController::class, 'destroy'])
        ->name('campaign-members.destroy');

    Route::resource('products', ProductController::class);

    Route::post('/price-books/{priceBook}/entries', [PriceBookController::class, 'addEntry'])
        ->name('price-books.entries.store');

    Route::delete('/price-book-entries/{priceBookEntry}', [PriceBookController::class, 'removeEntry'])
        ->name('price-book-entries.destroy');

    Route::resource('price-books', PriceBookController::class);

    Route::post('/quotes/{quote}/line-items', [QuoteController::class, 'addLineItem'])
        ->name('quotes.line-items.store');

    Route::delete('/quote-line-items/{quoteLineItem}', [QuoteController::class, 'removeLineItem'])
        ->name('quote-line-items.destroy');

    Route::resource('quotes', QuoteController::class);

    Route::post('/quotes/{quote}/convert-to-sales-order', [SalesOrderController::class, 'convertFromQuote'])
         ->name('quotes.convert-to-sales-order');

    Route::resource('sales-orders', SalesOrderController::class)
        ->only(['index', 'show']);

    Route::post('/sales-orders/{salesOrder}/convert-to-invoice', [InvoiceController::class, 'convertFromSalesOrder'])
        ->name('sales-orders.convert-to-invoice');

    Route::resource('invoices', InvoiceController::class)
        ->only(['index', 'show']);

    Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store'])
        ->name('invoices.payments.store');

    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])
        ->name('payments.destroy');

    Route::resource('payments', PaymentController::class)
        ->only(['index']);
});

require __DIR__.'/auth.php';
