<?php

namespace App\Http\Controllers;

use App\Models\CrmTask;
use Illuminate\Http\Request;

class CrmTaskController extends Controller
{
    public function index()
    {
        $tasks = CrmTask::latest()
            ->paginate(15);

        return view('crm_tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('crm_tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'taskable_type' => ['nullable', 'string', 'max:255'],
            'taskable_id' => ['nullable', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
        ]);

        CrmTask::create($validated);

        return redirect()
            ->route('crm-tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(CrmTask $crmTask)
    {
        return view('crm_tasks.show', compact('crmTask'));
    }

    public function edit(CrmTask $crmTask)
    {
        return view('crm_tasks.edit', compact('crmTask'));
    }

    public function update(Request $request, CrmTask $crmTask)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:255'],
            'due_date' => ['nullable', 'date'],
        ]);

        if ($validated['status'] === 'Completed' && !$crmTask->completed_at) {
            $validated['completed_at'] = now();
        }

        if ($validated['status'] !== 'Completed') {
            $validated['completed_at'] = null;
        }

        $crmTask->update($validated);

        return redirect()
            ->route('crm-tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(CrmTask $crmTask)
    {
        $crmTask->delete();

        return redirect()
            ->route('crm-tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function complete(CrmTask $crmTask)
    {
        $crmTask->markCompleted();

        return back()->with('success', 'Task marked complete.');
    }
}
