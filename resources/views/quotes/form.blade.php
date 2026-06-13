@if($errors->any())
    <div class="alert alert-danger">
        <strong>Fix the following errors:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $selectedOpportunityId = old(
        'opportunity_id',
        $quote->opportunity_id ?? $selectedOpportunity?->id ?? ''
    );

    $selectedAccountId = old(
        'account_id',
        $quote->account_id ?? $selectedOpportunity?->account_id ?? ''
    );
@endphp

<div class="mb-3">
    <label class="form-label">Quote Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $quote->name ?? ($selectedOpportunity ? 'Quote for '.$selectedOpportunity->name : '')) }}"
           required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Opportunity</label>
        <select name="opportunity_id" class="form-select">
            <option value="">No Opportunity</option>
            @foreach($opportunities as $opportunity)
                <option value="{{ $opportunity->id }}" @selected($selectedOpportunityId == $opportunity->id)>
                    {{ $opportunity->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Account</label>
        <select name="account_id" class="form-select">
            <option value="">No Account</option>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}" @selected($selectedAccountId == $account->id)>
                    {{ $account->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Contact</label>
        <select name="contact_id" class="form-select">
            <option value="">No Contact</option>
            @foreach($contacts as $contact)
                <option value="{{ $contact->id }}"
                    @selected(old('contact_id', $quote->contact_id ?? '') == $contact->id)>
                    {{ $contact->full_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Price Book</label>
        <select name="price_book_id" class="form-select">
            <option value="">No Price Book</option>
            @foreach($priceBooks as $priceBook)
                <option value="{{ $priceBook->id }}"
                    @selected(old('price_book_id', $quote->price_book_id ?? '') == $priceBook->id)>
                    {{ $priceBook->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach(['Draft', 'Presented', 'Accepted', 'Rejected', 'Expired'] as $status)
                <option value="{{ $status }}"
                    @selected(old('status', $quote->status ?? 'Draft') === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Expiration Date</label>
        <input type="date" name="expiration_date" class="form-control"
               value="{{ old('expiration_date', isset($quote) && $quote->expiration_date ? $quote->expiration_date->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Terms</label>
    <textarea name="terms" rows="4" class="form-control">{{ old('terms', $quote->terms ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="notes" rows="4" class="form-control">{{ old('notes', $quote->notes ?? '') }}</textarea>
</div>
