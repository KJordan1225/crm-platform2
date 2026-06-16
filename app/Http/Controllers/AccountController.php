<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::with(['owner', 'salesTeam'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('industry', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('industry'), function ($query) use ($request) {
                $query->where('industry', $request->industry);
            })
            ->when($request->filled('sales_team_id'), function ($query) use ($request) {
                $query->where('sales_team_id', $request->sales_team_id);
            })
            ->when($request->boolean('mine'), function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $industries = Account::whereNotNull('industry')
            ->distinct()
            ->orderBy('industry')
            ->pluck('industry');

        $salesTeams = SalesTeam::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('accounts.index', compact('accounts', 'industries', 'salesTeams'));
    }


    public function create()
    {
        $salesTeams = SalesTeam::where('is_active', true)->orderBy('name')->get();

        return view('accounts.create', compact('salesTeams'));
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

        $validated['user_id'] = Auth::id();

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
        $salesTeams = SalesTeam::where('is_active', true)->orderBy('name')->get();
    
        return view('accounts.edit', compact('account', 'salesTeams'));
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
