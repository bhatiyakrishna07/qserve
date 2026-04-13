@extends('admin.layouts.app')
@section('title', 'Add Food Item')

@section('content')
<div class="card" style="max-width:650px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Add New Food Item</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.food-items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Food Name <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Chicken Burger">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"
                          class="form-control"
                          placeholder="Short description of the item...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Price (₹) <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">₹</span>
                    </div>
                    <input type="number" name="price" step="0.01" min="0"
                           class="form-control @error('price') is-invalid @enderror"
                           value="{{ old('price') }}" placeholder="0.00">
                </div>
                @error('price')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Image <span class="text-muted">(optional)</span></label>
                <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input"
                           id="imageInput" accept="image/*"
                           onchange="previewImage(this)">
                    <label class="custom-file-label" for="imageInput">Choose image</label>
                </div>
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img id="previewImg" src="" width="100" height="100"
                         style="object-fit:cover; border-radius:8px; border:2px solid #ddd;">
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_available" class="custom-control-input"
                           id="is_available" checked>
                    <label class="custom-control-label" for="is_available">Available</label>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Food Item
                </button>
                <a href="{{ route('admin.food-items.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.querySelector('.custom-file-label').textContent = input.files[0].name;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection