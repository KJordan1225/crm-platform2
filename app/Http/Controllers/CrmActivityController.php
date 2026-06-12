<?php

namespace App\Http\Controllers;

use App\Models\CrmActivity;
use Illuminate\Http\Request;

class CrmActivityController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'activityable_type' => ['required', 'string'],
            'activityable_id' => ['required', 'integer'],
            'type' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'activity_date' => ['nullable', 'date'],
        ]);

        CrmActivity::create($validated);

        return back()->with('success', 'Activity logged successfully.');
    }

    public function destroy(CrmActivity $crmActivity)
    {
        $crmActivity->delete();

        return back()->with('success', 'Activity deleted successfully.');
    }
}
