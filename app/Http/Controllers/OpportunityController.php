<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::with('account')->latest()->paginate(10);

        return view('opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        $accounts = Account::orderBy('name')->get();

        return view('opportunities.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => ['nullable', 'exists:accounts,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'stage' => ['required', 'string', 'max:255'],
            'probability' => ['required', 'integer', 'min:0', 'max:100'],
            'close_date' => ['nullable', 'date'],
            'source' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Opportunity::create($validated);

        return redirect()
            ->route('opportunities.index')
            ->with('success', 'Opportunity created successfully.');
    }

    public function show(Opportunity $opportunity)
    {
        $opportunity->load('account');

        return view('opportunities.show', compact('opportunity'));
    }

    public function edit(Opportunity $opportunity)
    {
        $accounts = Account::orderBy('name')->get();

        return view('opportunities.edit', compact('opportunity', 'accounts'));
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'account_id' => ['nullable', 'exists:accounts,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'stage' => ['required', 'string', 'max:255'],
            'probability' => ['required', 'integer', 'min:0', 'max:100'],
            'close_date' => ['nullable', 'date'],
            'source' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $opportunity->update($validated);

        return redirect()
            ->route('opportunities.index')
            ->with('success', 'Opportunity updated successfully.');
    }

    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();

        return redirect()
            ->route('opportunities.index')
            ->with('success', 'Opportunity deleted successfully.');
    }
}
