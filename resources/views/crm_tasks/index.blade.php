@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Tasks</h1>
            <p class="text-muted">Manage sales follow-ups, reminders, and action items.</p>
        </div>

        <a href="{{ route('crm-tasks.create') }}" class="btn btn-primary">
            New Task
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Related To</th>
                        <th>Owner</th>
                        <th width="260">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>
                                <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : 'secondary' }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->due_date?->format('m/d/Y') }}</td>
                            <td>
                                @if($task->taskable)
                                    {{ class_basename($task->taskable_type) }} #{{ $task->taskable_id }}
                                @else
                                    General
                                @endif
                            </td>
                            <td>{{ $task->owner->name ?? 'None' }}</td>
                                <a href="{{ route('crm-tasks.show', $task) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('crm-tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>

                                @if($task->status !== 'Completed')
                                    <form action="{{ route('crm-tasks.complete', $task) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            Complete
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('crm-tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this task?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $tasks->links() }}
        </div>
    </div>
</div>
@endsection