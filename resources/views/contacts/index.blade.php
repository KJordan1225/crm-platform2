@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Contacts</h1>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary">New Contact</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <x-crm.search-form
        :action="route('contacts.index')"
        placeholder="Search contacts by name, email, phone, or mobile..."
    >
        <x-crm.select-filter
            name="account_id"
            label="Account"
            default="All Accounts"
            :options="$accounts->pluck('name', 'id')"
            class="col-md-4"
        />

        <div class="col-md-2">
            <div class="form-check mt-4">
                <input type="checkbox"
                    name="mine"
                    value="1"
                    class="form-check-input"
                    id="mine"
                    @checked(request()->boolean('mine'))>

                <label for="mine" class="form-check-label">
                    My Records
                </label>
            </div>
        </div>

    </x-crm.search-form>



    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Owner</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->full_name }}</td>
                            <td>{{ $contact->account?->name ?? 'None' }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->owner->name ?? 'None' }}</td>
                            <td>
                                <a href="{{ route('contacts.show', $contact) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('contacts.edit', $contact) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this contact?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No contacts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $contacts->links() }}
        </div>
    </div>
</div>
@endsection
