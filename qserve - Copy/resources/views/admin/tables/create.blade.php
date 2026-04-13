@extends('admin.layouts.app')
@section('title', 'Add Table')

@section('content')
<div class="card" style="max-width:500px;">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Add New Table</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Table Name <span class="text-danger">*</span></label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="e.g. Table 1, Window Table, VIP Table">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Capacity <span class="text-danger">*</span></label>
                <input type="number" name="capacity"
                       class="form-control @error('capacity') is-invalid @enderror"
                       value="{{ old('capacity', 2) }}"
                       min="1" max="20"
                       placeholder="Number of persons">
                <small class="text-muted">How many people can sit at this table</small>
                @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                A <strong>QR Code</strong> will be automatically generated when you save the table.
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Save & Generate QR
                </button>
                <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection