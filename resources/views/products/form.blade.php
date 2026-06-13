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
    <label class="form-label">Product Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">SKU</label>
        <input type="text" name="sku" class="form-control"
               value="{{ old('sku', $product->sku ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control"
               value="{{ old('category', $product->category ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Unit Price</label>
        <input type="number" step="0.01" name="unit_price" class="form-control"
               value="{{ old('unit_price', $product->unit_price ?? 0) }}">
    </div>
</div>

<div class="form-check mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" class="form-check-input"
           id="is_active"
           @checked(old('is_active', $product->is_active ?? true))>
    <label for="is_active" class="form-check-label">
        Active Product
    </label>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>
