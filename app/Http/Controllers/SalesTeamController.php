<?php

namespace App\Http\Controllers;

use App\Models\SalesTeam;
use App\Models\SalesTeamMember;
use App\Models\User;
use Illuminate\Http\Request;

class SalesTeamController extends Controller
{
    public function index()
    {
        $salesTeams = SalesTeam::with(['manager'])
            ->withCount(['members', 'accounts', 'leads', 'opportunities'])
            ->latest()
            ->paginate(10);

        return view('sales_teams.index', compact('salesTeams'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('sales_teams.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateSalesTeam($request);

        SalesTeam::create($validated);

        return redirect()
            ->route('sales-teams.index')
            ->with('success', 'Sales team created successfully.');
    }

    public function show(SalesTeam $salesTeam)
    {
        $salesTeam->load([
            'manager',
            'members.user',
            'accounts',
            'leads',
            'opportunities',
        ]);

        $users = User::orderBy('name')->get();

        return view('sales_teams.show', compact('salesTeam', 'users'));
    }

    public function edit(SalesTeam $salesTeam)
    {
        $users = User::orderBy('name')->get();

        return view('sales_teams.edit', compact('salesTeam', 'users'));
    }

    public function update(Request $request, SalesTeam $salesTeam)
    {
        $validated = $this->validateSalesTeam($request);

        $salesTeam->update($validated);

        return redirect()
            ->route('sales-teams.index')
            ->with('success', 'Sales team updated successfully.');
    }

    public function destroy(SalesTeam $salesTeam)
    {
        $salesTeam->delete();

        return redirect()
            ->route('sales-teams.index')
            ->with('success', 'Sales team deleted successfully.');
    }

    public function addMember(Request $request, SalesTeam $salesTeam)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'string', 'max:255'],
            'joined_at' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        SalesTeamMember::updateOrCreate(
            [
                'sales_team_id' => $salesTeam->id,
                'user_id' => $validated['user_id'],
            ],
            [
                'role' => $validated['role'],
                'joined_at' => $validated['joined_at'] ?? now()->toDateString(),
                'is_active' => $request->boolean('is_active'),
            ]
        );

        return back()->with('success', 'Team member saved successfully.');
    }

    public function removeMember(SalesTeamMember $salesTeamMember)
    {
        $salesTeamMember->delete();

        return back()->with('success', 'Team member removed successfully.');
    }

    private function validateSalesTeam(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
