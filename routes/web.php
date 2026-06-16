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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\CrmExportController;
use App\Http\Controllers\CrmImportController;
use App\Http\Controllers\SalesTeamController;


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

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/search', [GlobalSearchController::class, 'index'])
        ->name('search.index');

    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('/accounts', [CrmExportController::class, 'accounts'])->name('accounts');
        Route::get('/contacts', [CrmExportController::class, 'contacts'])->name('contacts');
        Route::get('/leads', [CrmExportController::class, 'leads'])->name('leads');
        Route::get('/opportunities', [CrmExportController::class, 'opportunities'])->name('opportunities');
        Route::get('/quotes', [CrmExportController::class, 'quotes'])->name('quotes');
        Route::get('/invoices', [CrmExportController::class, 'invoices'])->name('invoices');
        Route::get('/payments', [CrmExportController::class, 'payments'])->name('payments');
    });

    Route::get('/imports', [CrmImportController::class, 'index'])
        ->name('imports.index');

    Route::post('/imports/accounts', [CrmImportController::class, 'accounts'])
        ->name('imports.accounts');

    Route::post('/imports/contacts', [CrmImportController::class, 'contacts'])
        ->name('imports.contacts');

    Route::post('/imports/leads', [CrmImportController::class, 'leads'])
        ->name('imports.leads');

    Route::get('/imports/templates/accounts', [CrmImportController::class, 'accountTemplate'])
        ->name('imports.templates.accounts');

    Route::get('/imports/templates/contacts', [CrmImportController::class, 'contactTemplate'])
        ->name('imports.templates.contacts');

    Route::get('/imports/templates/leads', [CrmImportController::class, 'leadTemplate'])
        ->name('imports.templates.leads');

    Route::post('/sales-teams/{salesTeam}/members', [SalesTeamController::class, 'addMember'])
        ->name('sales-teams.members.store');

    Route::delete('/sales-team-members/{salesTeamMember}', [SalesTeamController::class, 'removeMember'])
        ->name('sales-team-members.destroy');

    Route::resource('sales-teams', SalesTeamController::class);

});

require __DIR__.'/auth.php';
