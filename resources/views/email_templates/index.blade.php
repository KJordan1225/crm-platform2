@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Email Templates</h1>
            <p class="text-muted">Reusable email messages for leads and contacts.</p>
        </div>

        <a href="{{ route('email-templates.create') }}" class="btn btn-primary">
            New Template
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
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($templates as $template)
                        <tr>
                            <td>{{ $template->name }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>{{ $template->category }}</td>
                            <td>
                                <span class="badge bg-{{ $template->is_active ? 'success' : 'secondary' }}">
                                    {{ $template->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('email-templates.show', $template) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('email-templates.edit', $template) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('email-templates.destroy', $template) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this template?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No email templates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $templates->links() }}
        </div>
    </div>
</div>
@endsection
