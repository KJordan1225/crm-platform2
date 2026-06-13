<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $leads = Lead::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('source'), function ($query) use ($request) {
                $query->where('source', $request->source);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statuses = ['New', 'Working', 'Qualified', 'Unqualified', 'Converted'];

        $sources = [
            'Website',
            'Referral',
            'Cold Call',
            'Email Campaign',
            'Social Media',
            'Trade Show',
            'Other',
        ];

        return view('leads.index', compact('leads', 'statuses', 'sources'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        Lead::create($validated);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load([
            'tasks' => fn ($q) => $q->latest(),
            'notes' => fn ($q) => $q->latest(),
            'activities' => fn ($q) => $q->latest(),
        ]);

        return view('leads.show', compact('lead'));
    }


    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'company' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $lead->update($validated);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }

    public function convert(Lead $lead)
    {
        DB::transaction(function () use ($lead) {
            $account = Account::create([
                'name' => $lead->company ?: $lead->full_name,
                'industry' => $lead->industry,
                'phone' => $lead->phone,
                'email' => $lead->email,
                'description' => $lead->notes,
            ]);

            Contact::create([
                'account_id' => $account->id,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'notes' => $lead->notes,
            ]);

            Opportunity::create([
                'account_id' => $account->id,
                'name' => 'Opportunity for ' . $account->name,
                'amount' => $lead->estimated_value ?? 0,
                'stage' => 'Prospecting',
                'probability' => 10,
                'source' => $lead->source,
                'description' => $lead->notes,
            ]);

            $lead->update([
                'status' => 'Converted',
            ]);
        });

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead converted into Account, Contact, and Opportunity.');
    }
}
