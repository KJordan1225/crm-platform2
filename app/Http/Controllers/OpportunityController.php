<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Opportunity;
use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $opportunities = Opportunity::with('account')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('source', 'like', "%{$search}%")
                        ->orWhereHas('account', function ($accountQuery) use ($search) {
                            $accountQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('stage'), function ($query) use ($request) {
                $query->where('stage', $request->stage);
            })
            ->when($request->boolean('mine'), function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stages = [
            'Prospecting',
            'Qualification',
            'Needs Analysis',
            'Proposal',
            'Negotiation',
            'Closed Won',
            'Closed Lost',
        ];

        return view('opportunities.index', compact('opportunities', 'stages'));
    }


    public function create()
    {
        $accounts = Account::orderBy('name')->get();
        $salesTeams = SalesTeam::where('is_active', true)->orderBy('name')->get();


        return view('opportunities.create', compact('accounts', 'salesTeams'));
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

           $validated['user_id'] = Auth::id();

        Opportunity::create($validated);

        return redirect()
            ->route('opportunities.index')
            ->with('success', 'Opportunity created successfully.');
    }

    public function show(Opportunity $opportunity)
    {
        $opportunity->load([
            'account',
            'tasks' => fn ($q) => $q->latest(),
            'notes' => fn ($q) => $q->latest(),
            'activities' => fn ($q) => $q->latest(),
        ]);

        return view('opportunities.show', compact('opportunity'));
    }
    

    public function edit(Opportunity $opportunity)
    {
        $accounts = Account::orderBy('name')->get();

        $salesTeams = SalesTeam::where('is_active', true)->orderBy('name')->get();

        return view('opportunities.edit', compact('opportunity', 'accounts', 'salesTeams'));
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
