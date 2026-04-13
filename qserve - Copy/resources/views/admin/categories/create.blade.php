@extends('admin.layouts.app')
@section('title', 'Add Category')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Add New Category</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Starters, Main Course">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Image <span class="text-muted">(optional)</span></label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input"
                               id="imageInput" accept="image/*"
                               onchange="previewImage(this)">
                        <label class="custom-file-label" for="imageInput">Choose image</label>
                    </div>
                </div>
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img id="previewImg" src="" width="100" height="100"
                         style="object-fit:cover; border-radius:8px; border:2px solid #ddd;">
                </div>
                @error('image')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_active" class="custom-control-input"
                           id="is_active" checked>
                    <label class="custom-control-label" for="is_active">Active</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">
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