<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignMember;
use App\Models\Contact;
use App\Models\Lead;
use Illuminate\Http\Request;

class CampaignMemberController extends Controller
{
    public function store(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'member_type' => ['required', 'in:lead,contact'],
            'member_id' => ['required', 'integer'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $memberableType = $validated['member_type'] === 'lead'
            ? Lead::class
            : Contact::class;

        $exists = $memberableType::whereKey($validated['member_id'])->exists();

        if (!$exists) {
            return back()->withErrors([
                'member_id' => 'Selected campaign member does not exist.',
            ]);
        }

        CampaignMember::firstOrCreate(
            [
                'campaign_id' => $campaign->id,
                'memberable_type' => $memberableType,
                'memberable_id' => $validated['member_id'],
            ],
            [
                'status' => $validated['status'],
            ]
        );

        return back()->with('success', 'Campaign member added successfully.');
    }

    public function update(Request $request, CampaignMember $campaignMember)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'max:255'],
        ]);

        $campaignMember->update($validated);

        return back()->with('success', 'Campaign member updated successfully.');
    }

    public function destroy(CampaignMember $campaignMember)
    {
        $campaignMember->delete();

        return back()->with('success', 'Campaign member removed successfully.');
    }
}
