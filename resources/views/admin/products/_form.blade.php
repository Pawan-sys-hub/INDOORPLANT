{{-- Shared product form partial for create/edit --}}
<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-semibold">Product Name *</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Category *</label>
        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Select…</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Price (NPR) *</label>
        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? '') }}" required min="0" step="0.01">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Discount Price</label>
        <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price ?? '') }}" min="0" step="0.01">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Stock Quantity *</label>
        <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" required min="0">
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Light Requirements</label>
        <input type="text" name="light" class="form-control" value="{{ old('light', $product->light ?? '') }}" placeholder="e.g. Bright Indirect">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Watering</label>
        <input type="text" name="water" class="form-control" value="{{ old('water', $product->water ?? '') }}" placeholder="e.g. Weekly">
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Difficulty</label>
        <input type="text" name="difficulty" class="form-control" value="{{ old('difficulty', $product->difficulty ?? '') }}" placeholder="e.g. Easy">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Status *</label>
        <select name="status" class="form-select" required>
            <option value="active" {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_featured" id="isFeatured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="isFeatured">⭐ Featured Product</label>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Product Image</label>
        @isset($product)
        @if($product->image_path)
        <div class="mb-2">
            <img src="{{ $product->image_url }}" style="height:80px;border-radius:8px;object-fit:cover" alt="Current">
            <span class="text-muted small ms-2">Current image</span>
        </div>
        @endif
        @endisset
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpg,image/jpeg,image/png,image/webp">
        <div class="form-text">Max 2MB · JPG, PNG, WebP only</div>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
