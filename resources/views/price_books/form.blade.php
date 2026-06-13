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

<div class="mb-3">
    <label class="form-label">Price Book Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $priceBook->name ?? '') }}" required>
</div>

<div class="form-check mb-3">
    <input type="hidden" name="is_standard" value="0">
    <input type="checkbox" name="is_standard" value="1" class="form-check-input"
           id="is_standard"
           @checked(old('is_standard', $priceBook->is_standard ?? false))>
    <label for="is_standard" class="form-check-label">
        Standard Price Book
    </label>
</div>

<div class="form-check mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" class="form-check-input"
           id="is_active"
           @checked(old('is_active', $priceBook->is_active ?? true))>
    <label for="is_active" class="form-check-label">
        Active Price Book
    </label>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="5" class="form-control">{{ old('description', $priceBook->description ?? '') }}</textarea>
</div>
