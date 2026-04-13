@extends('admin.layouts.app')
@section('title', 'Edit Table')

@section('content')
<div class="row">

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Table</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tables.update', $table) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Table Name <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $table->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Capacity <span class="text-danger">*</span></label>
                        <input type="number" name="capacity"
                               class="form-control @error('capacity') is-invalid @enderror"
                               value="{{ old('capacity', $table->capacity) }}"
                               min="1" max="20">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>
                                Available
                            </option>
                            <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>
                                Occupied
                            </option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Table
                        </button>
                        <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- QR Code Preview --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-qrcode mr-2"></i> QR Code</h3>
            </div>
            <div class="card-body text-center">
                @if($table->qr_code)
                    <img src="{{ Storage::url($table->qr_code) }}"
                         style="width:180px; height:180px; border:3px solid #ddd; border-radius:8px;">
                    <p class="text-muted small mt-2">{{ $table->name }}</p>
                    <div class="mt-2">
                        <a href="{{ Storage::url($table->qr_code) }}"
                           download="qr-{{ $table->name }}.svg"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-download mr-1"></i> Download QR
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.tables.regenerate-qr', $table) }}"
                           class="btn btn-secondary btn-sm"
                           onclick="return confirm('Regenerate QR Code?')">
                            <i class="fas fa-sync mr-1"></i> Regenerate QR
                        </a>
                    </div>
                @else
                    <p class="text-muted">No QR code yet</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection