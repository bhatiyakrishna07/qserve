@extends('admin.layouts.app')
@section('title', 'Food Items')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-burger mr-2"></i> All Food Items</h3>
        <a href="{{ route('admin.food-items.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Add Food Item
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($foodItems as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}"
                                 width="50" height="50"
                                 style="object-fit:cover; border-radius:8px;">
                        @else
                            <div style="width:50px;height:50px;background:#f0f0f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if($item->description)
                            <br><small class="text-muted">{{ Str::limit($item->description, 40) }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $item->category->name ?? 'No Category' }}</span>
                    </td>
                    <td><strong>₹{{ number_format($item->price, 2) }}</strong></td>
                    <td>
                        @if($item->is_available)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-danger">No</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.food-items.edit', $item) }}"
                           class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.food-items.destroy', $item) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this food item?')">
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
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        No food items found.
                        <a href="{{ route('admin.food-items.create') }}">Add one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $foodItems->links() }}
    </div>
</div>
@endsection