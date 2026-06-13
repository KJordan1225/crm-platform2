<form method="GET" action="{{ $action }}" class="card card-body shadow-sm border-0 mb-3">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Search</label>
            <input type="text"
                   name="search"
                   class="form-control"
                   value="{{ request('search') }}"
                   placeholder="{{ $placeholder ?? 'Search records...' }}">
        </div>

        @isset($filters)
            {!! $filters !!}
        @endisset

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                Search
            </button>
        </div>

        <div class="col-md-2">
            <a href="{{ $action }}" class="btn btn-outline-secondary w-100">
                Reset
            </a>
        </div>
    </div>
</form>
