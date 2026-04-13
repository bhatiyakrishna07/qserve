<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::latest()->paginate(10);
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:191|unique:tables,name',
            'capacity' => 'required|integer|min:1|max:20',
        ]);

        // Create table first to get ID
        $table = Table::create([
            'name'     => $request->name,
            'capacity' => $request->capacity,
            'status'   => 'available',
        ]);

        // Generate QR Code URL (customer menu URL with table id)
        $qrUrl = url('/menu?table=' . $table->id);

        // Generate and save QR code image
        $qrPath = 'qrcodes/table-' . $table->id . '.svg';

        $qrImage = QrCode::format('svg')
                         ->size(300)
                         ->margin(2)
                         ->generate($qrUrl);

        Storage::disk('public')->put($qrPath, $qrImage);

        // Update table with QR code path
        $table->update(['qr_code' => $qrPath]);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table created with QR Code successfully!');
    }

    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $request->validate([
            'name'     => 'required|string|max:191|unique:tables,name,' . $table->id,
            'capacity' => 'required|integer|min:1|max:20',
            'status'   => 'required|in:available,occupied',
        ]);

        $table->update([
            'name'     => $request->name,
            'capacity' => $request->capacity,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table updated successfully!');
    }

    public function destroy(Table $table)
    {
        // Delete QR code image
        if ($table->qr_code) {
            Storage::disk('public')->delete($table->qr_code);
        }

        $table->delete();

        return redirect()->route('admin.tables.index')
                         ->with('success', 'Table deleted successfully!');
    }

    // Regenerate QR Code
    public function regenerateQr(Table $table)
    {
        $qrUrl = url('/menu?table=' . $table->id);
        $qrPath = 'qrcodes/table-' . $table->id . '.svg';

        $qrImage = QrCode::format('svg')
                         ->size(300)
                         ->margin(2)
                         ->generate($qrUrl);

        Storage::disk('public')->put($qrPath, $qrImage);
        $table->update(['qr_code' => $qrPath]);

        return redirect()->route('admin.tables.index')
                         ->with('success', 'QR Code regenerated successfully!');
    }
}