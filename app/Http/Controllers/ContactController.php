<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('account')->latest()->paginate(10);

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        $accounts = Account::orderBy('name')->get();

        return view('contacts.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => ['nullable', 'exists:accounts,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Contact::create($validated);

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact)
    {
        $contact->load('account');

        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $accounts = Account::orderBy('name')->get();

        return view('contacts.edit', compact('contact', 'accounts'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'account_id' => ['nullable', 'exists:accounts,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $contact->update($validated);

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}
