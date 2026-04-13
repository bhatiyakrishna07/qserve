@extends('admin.layouts.app')
@section('title', 'Categories')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-tags mr-2"></i> All Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Add Category
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}"
                                 width="50" height="50"
                                 style="object-fit:cover; border-radius:8px;">
                        @else
                            <div style="width:50px;height:50px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>
                        <span class="badge badge-info">
                            {{ $category->foodItems->count() }} items
                        </span>
                    </td>
                    <td>
                        @if($category->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        No categories found.
                        <a href="{{ route('admin.categories.create') }}">Add one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
</div>
@endsection