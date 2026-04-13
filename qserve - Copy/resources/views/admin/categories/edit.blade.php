@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Category</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                @if($category->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($category->image) }}"
                             width="80" height="80"
                             style="object-fit:cover; border-radius:8px; border:2px solid #ddd;">
                        <small class="text-muted d-block mt-1">Current image</small>
                    </div>
                @endif
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input"
                               id="imageInput" accept="image/*"
                               onchange="previewImage(this)">
                        <label class="custom-file-label" for="imageInput">Choose new image</label>
                    </div>
                </div>
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img id="previewImg" src="" width="80" height="80"
                         style="object-fit:cover; border-radius:8px; border:2px solid #ddd;">
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="is_active" class="custom-control-input"
                           id="is_active" {{ $category->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Active</label>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Update Category
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