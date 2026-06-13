@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold">Price Books</h1>
            <p class="text-muted">Manage standard and custom pricing catalogs.</p>
        </div>

        <a href="{{ route('price-books.create') }}" class="btn btn-primary">
            New Price Book
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
                        <th>Entries</th>
                        <th>Standard</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($priceBooks as $priceBook)
                        <tr>
                            <td>{{ $priceBook->name }}</td>
                            <td>{{ $priceBook->entries_count }}</td>
                            <td>{{ $priceBook->is_standard ? 'Yes' : 'No' }}</td>
                            <td>
                                <span class="badge bg-{{ $priceBook->is_active ? 'success' : 'secondary' }}">
                                    {{ $priceBook->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('price-books.show', $priceBook) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('price-books.edit', $priceBook) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('price-books.destroy', $priceBook) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this price book?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No price books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $priceBooks->links() }}
        </div>
    </div>
</div>
@endsection
