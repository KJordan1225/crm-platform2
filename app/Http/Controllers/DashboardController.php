<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAccounts = Account::count();
        $totalContacts = Contact::count();
        $totalLeads = Lead::count();
        $totalOpportunities = Opportunity::count();

        $pipelineValue = Opportunity::whereNotIn('stage', ['Closed Lost'])
            ->sum('amount');

        $wonValue = Opportunity::where('stage', 'Closed Won')
            ->sum('amount');

        $openOpportunities = Opportunity::whereNotIn('stage', ['Closed Won', 'Closed Lost'])
            ->latest()
            ->limit(5)
            ->get();

        $recentLeads = Lead::latest()
            ->limit(5)
            ->get();

        $opportunitiesByStage = Opportunity::selectRaw('stage, COUNT(*) as total, SUM(amount) as value')
            ->groupBy('stage')
            ->orderByRaw("FIELD(stage, 'Prospecting', 'Qualification', 'Needs Analysis', 'Proposal', 'Negotiation', 'Closed Won', 'Closed Lost')")
            ->get();

        return view('dashboard', compact(
            'totalAccounts',
            'totalContacts',
            'totalLeads',
            'totalOpportunities',
            'pipelineValue',
            'wonValue',
            'openOpportunities',
            'recentLeads',
            'opportunitiesByStage'
        ));
    }
}
