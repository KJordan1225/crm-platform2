<?php

namespace App\Http\Controllers;

use App\Models\CrmNote;
use Illuminate\Http\Request;

class CrmNoteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'noteable_type' => ['required', 'string'],
            'noteable_id' => ['required', 'integer'],
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        CrmNote::create($validated);

        return back()->with('success', 'Note added successfully.');
    }

    public function destroy(CrmNote $crmNote)
    {
        $crmNote->delete();

        return back()->with('success', 'Note deleted successfully.');
    }
}
