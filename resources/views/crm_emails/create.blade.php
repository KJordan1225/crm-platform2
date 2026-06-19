@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold mb-3">
        Send Email to {{ $record->full_name }}
    </h1>

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

    <form action="{{ route('crm-emails.send') }}" method="POST" class="card card-body shadow-sm border-0">
        @csrf

        <input type="hidden" name="record_type" value="{{ $recordType }}">
        <input type="hidden" name="record_id" value="{{ $record->id }}">

        <div class="mb-3">
            <label class="form-label">Template</label>
            <select class="form-select" id="templateSelect">
                <option value="">No Template</option>
                @foreach($templates as $template)
                    <option value="{{ $template->id }}"
                            data-subject="{{ e($template->subject) }}"
                            data-body="{{ e($template->body) }}">
                        {{ $template->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">To Name</label>
                <input type="text"
                       name="to_name"
                       class="form-control"
                       value="{{ old('to_name', $record->full_name) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">To Email</label>
                <input type="email"
                       name="to_email"
                       class="form-control"
                       value="{{ old('to_email', $record->email) }}"
                       required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text"
                   name="subject"
                   id="emailSubject"
                   class="form-control"
                   value="{{ old('subject') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body"
                      id="emailBody"
                      rows="12"
                      class="form-control"
                      required>{{ old('body') }}</textarea>
        </div>

        <button class="btn btn-primary">
            Send Email
        </button>
    </form>
</div>

<script>
    document.getElementById('templateSelect').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];

        document.getElementById('emailSubject').value = selected.dataset.subject || '';
        document.getElementById('emailBody').value = selected.dataset.body || '';
    });
</script>
@endsection
