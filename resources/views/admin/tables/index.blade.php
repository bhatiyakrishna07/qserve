@extends('admin.layouts.app')
@section('title', 'Tables & QR Codes')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-chair mr-2"></i> All Tables</h3>
        <a href="{{ route('admin.tables.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Add Table
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Table Name</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tables as $table)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $table->name }}</strong></td>
                    <td>
                        <i class="fas fa-users mr-1 text-muted"></i>
                        {{ $table->capacity }} persons
                    </td>
                    <td>
                        @if($table->status === 'available')
                            <span class="badge badge-success">Available</span>
                        @else
                            <span class="badge badge-danger">Occupied</span>
                        @endif
                    </td>
                    <td>
                        @if($table->qr_code)
                            <img src="{{ Storage::url($table->qr_code) }}"
                                 width="60" height="60"
                                 style="border:2px solid #ddd; border-radius:6px; cursor:pointer;"
                                 onclick="showQrModal('{{ Storage::url($table->qr_code) }}', '{{ $table->name }}')"
                                 title="Click to enlarge">
                        @else
                            <span class="text-muted">No QR</span>
                        @endif
                    </td>
                    <td>
                        {{-- Download QR --}}
                        @if($table->qr_code)
                        <a href="{{ Storage::url($table->qr_code) }}"
                           download="qr-{{ $table->name }}.svg"
                           class="btn btn-info btn-xs">
                            <i class="fas fa-download"></i> QR
                        </a>
                        @endif

                        {{-- Regenerate QR --}}
                        <a href="{{ route('admin.tables.regenerate-qr', $table) }}"
                           class="btn btn-secondary btn-xs"
                           onclick="return confirm('Regenerate QR Code?')">
                            <i class="fas fa-sync"></i> Regen
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.tables.edit', $table) }}"
                           class="btn btn-warning btn-xs">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('admin.tables.destroy', $table) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this table?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-chair fa-2x mb-2 d-block"></i>
                        No tables found.
                        <a href="{{ route('admin.tables.create') }}">Add one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $tables->links() }}
    </div>
</div>

{{-- QR Code Modal --}}
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalTitle">QR Code</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="qrModalImg" src="" style="width:100%; max-width:280px;">
                <p class="mt-2 text-muted small">
                    Scan this QR code to place order
                </p>
            </div>
            <div class="modal-footer">
                <a id="qrDownloadBtn" href="" download class="btn btn-info btn-sm">
                    <i class="fas fa-download mr-1"></i> Download
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showQrModal(src, tableName) {
    document.getElementById('qrModalImg').src = src;
    document.getElementById('qrModalTitle').textContent = 'QR Code - ' + tableName;
    document.getElementById('qrDownloadBtn').href = src;
    document.getElementById('qrDownloadBtn').download = 'qr-' + tableName + '.svg';
    $('#qrModal').modal('show');
}
</script>
@endpush

@endsection