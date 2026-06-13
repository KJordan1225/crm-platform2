<div class="row g-4 mt-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <strong>Add Note</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('crm-notes.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="noteable_type" value="{{ get_class($model) }}">
                    <input type="hidden" name="noteable_id" value="{{ $model->id }}">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea name="body" rows="4" class="form-control" required></textarea>
                    </div>

                    <button class="btn btn-primary w-100">Save Note</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white">
                <strong>Log Activity</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('crm-activities.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="activityable_type" value="{{ get_class($model) }}">
                    <input type="hidden" name="activityable_id" value="{{ $model->id }}">

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="Call">Call</option>
                            <option value="Email">Email</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Demo">Demo</option>
                            <option value="Proposal Sent">Proposal Sent</option>
                            <option value="General">General</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Activity Date</label>
                        <input type="datetime-local" name="activity_date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-success w-100">Log Activity</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white">
                <strong>Add Task</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('crm-tasks.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="taskable_type" value="{{ get_class($model) }}">
                    <input type="hidden" name="taskable_id" value="{{ $model->id }}">

                    <div class="mb-3">
                        <label class="form-label">Task Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Open">Open</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Deferred">Deferred</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="Low">Low</option>
                            <option value="Normal" selected>Normal</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>

                    <button class="btn btn-warning w-100">Add Task</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <strong>Notes</strong>
            </div>

            <div class="list-group list-group-flush">
                @forelse($model->notes as $note)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $note->title ?? 'Untitled Note' }}</strong>
                                <div class="small text-muted">
                                    {{ $note->created_at->format('m/d/Y h:i A') }}
                                </div>
                            </div>

                            <form action="{{ route('crm-notes.destroy', $note) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this note?')" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </div>

                        <p class="mt-2 mb-0">{{ $note->body }}</p>
                    </div>
                @empty
                    <div class="list-group-item text-muted">No notes yet.</div>
                @endforelse
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <strong>Activities</strong>
            </div>

            <div class="list-group list-group-flush">
                @forelse($model->activities as $activity)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-primary">{{ $activity->type }}</span>
                                <strong>{{ $activity->subject }}</strong>
                                <div class="small text-muted">
                                    {{ $activity->activity_date?->format('m/d/Y h:i A') ?? $activity->created_at->format('m/d/Y h:i A') }}
                                </div>
                            </div>

                            <form action="{{ route('crm-activities.destroy', $activity) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this activity?')" class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </div>

                        <p class="mt-2 mb-0">{{ $activity->description }}</p>
                    </div>
                @empty
                    <div class="list-group-item text-muted">No activities yet.</div>
                @endforelse
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <strong>Tasks</strong>
            </div>

            <div class="list-group list-group-flush">
                @forelse($model->tasks as $task)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $task->title }}</strong>

                                <div class="small text-muted">
                                    Due:
                                    {{ $task->due_date?->format('m/d/Y') ?? 'No due date' }}
                                </div>

                                <div class="mt-1">
                                    <span class="badge bg-{{ $task->status === 'Completed' ? 'success' : 'secondary' }}">
                                        {{ $task->status }}
                                    </span>

                                    <span class="badge bg-dark">
                                        {{ $task->priority }}
                                    </span>
                                </div>

                                @if($task->description)
                                    <p class="mt-2 mb-0">{{ $task->description }}</p>
                                @endif
                            </div>

                            <div class="text-end">
                                @if($task->status !== 'Completed')
                                    <form action="{{ route('crm-tasks.complete', $task) }}" method="POST" class="mb-2">
                                        @csrf
                                        <button class="btn btn-sm btn-success">
                                            Complete
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('crm-tasks.edit', $task) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item text-muted">No tasks yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
