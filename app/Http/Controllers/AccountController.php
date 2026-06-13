<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::latest()->paginate(10);

        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Account::create($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        $account->load([
            'contacts',
            'opportunities',
            'tasks' => fn ($q) => $q->latest(),
            'notes' => fn ($q) => $q->latest(),
            'activities' => fn ($q) => $q->latest(),
        ]);

        return view('accounts.show', compact('account'));
    }


    public function edit(Account $account)
    {
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $account->update($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }
}
