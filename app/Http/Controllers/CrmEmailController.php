<?php

namespace App\Http\Controllers;

use App\Mail\CrmOutboundEmail;
use App\Models\Contact;
use App\Models\CrmEmailLog;
use App\Models\EmailTemplate;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CrmEmailController extends Controller
{
    public function createForLead(Lead $lead)
    {
        $templates = EmailTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('crm_emails.create', [
            'record' => $lead,
            'recordType' => 'lead',
            'templates' => $templates,
        ]);
    }

    public function createForContact(Contact $contact)
    {
        $templates = EmailTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('crm_emails.create', [
            'record' => $contact,
            'recordType' => 'contact',
            'templates' => $templates,
        ]);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'record_type' => ['required', 'in:lead,contact'],
            'record_id' => ['required', 'integer'],
            'to_email' => ['required', 'email'],
            'to_name' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $record = $validated['record_type'] === 'lead'
            ? Lead::findOrFail($validated['record_id'])
            : Contact::findOrFail($validated['record_id']);

        Mail::to($validated['to_email'])
            ->send(new CrmOutboundEmail($validated['subject'], $validated['body']));

        CrmEmailLog::create([
            'emailable_type' => get_class($record),
            'emailable_id' => $record->id,
            'user_id' => auth()->id(),
            'to_email' => $validated['to_email'],
            'to_name' => $validated['to_name'] ?? null,
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'status' => 'Sent',
            'sent_at' => now(),
        ]);

        return redirect()
            ->route($validated['record_type'] === 'lead' ? 'leads.show' : 'contacts.show', $record)
            ->with('success', 'Email sent and logged successfully.');
    }
}
