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

    @include('crm_shared.search_bar', [
        'action' => route('contacts.index'),
        'placeholder' => 'Search contacts...',
        'filters' => '
            <div class="col-md-4">
                <label class="form-label">Account</label>
                <select name="account_id" class="form-select">
                    <option value="">All Accounts</option>
                    ' . $accounts->map(function ($account) {
                        return '<option value="'.$account->id.'" '.(request('account_id') == $account->id ? 'selected' : '').'>'.$account->name.'</option>';
                    })->implode('') . '
                </select>
            </div>
        '
    ])


    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account</th>
                        <th>Email</th>
                        <th>Phone</th>
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
