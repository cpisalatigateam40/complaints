<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Plant;
use App\Models\Product;
use App\Models\RootCause;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaint = Complaint::all();
        return view('complaints.index', [
            'complaints' => $complaint
        ]);
    }

    public function create()
    {
        $products = Product::all();
        return view('complaints.create', [
            'products' => $products
        ]);
    }


    public function store(Request $request)
    {
        // ✅ Validation
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'tanggalKedatangan' => 'required|date',
            'namaProduk' => 'required|string|max:255',
            'kodeProduksi' => 'required|string|max:255',
            'bestBefore' => 'required|date',
            'jumlahKomplain' => 'required|integer|min:1',
            'jenisKetidaksesuaian' => 'required|string',
            'ncr' => 'nullable|string|max:255',
            'pelanggan' => 'required|string|max:255',
            'cabang' => 'required|string|max:255',
            'penyampaian' => 'required|string|max:50',
            'lokasiMasalah' => 'nullable|array',
            'lokasiMasalah.*' => 'string',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);

        // ✅ Upload file (if exists)
        $filePath = null;
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $filename = $file->getClientOriginalExtension();
            $filePath = $file->storeAs('complaint_docs', $filename, 'public');
        }
        $product = Product::first();
        $plant = Plant::first();
        // ✅ Create complaint
        $complaint = Complaint::create([
            'date' => $validated['tanggal'],
            'product_arrival_date' => $validated['tanggalKedatangan'],
            'product_uuid' => $product->uuid, // You can set product UUID if available
            'production_code' => $validated['kodeProduksi'],
            'best_before' => $validated['bestBefore'],
            'complaint_amount' => $validated['jumlahKomplain'],
            'nonconformity_type' => $validated['jenisKetidaksesuaian'],
            'ncr' => $validated['ncr'] ?? null,
            'complaint_documentation' => $filePath,
            'customer' => $validated['pelanggan'],
            'plant_uuid' => $plant->uuid, // You can map 'cabang' to a plant if needed
            'delivery' => $validated['penyampaian'],
            'status' => '0',
        ]);

        // ✅ Store root cause locations
        if (!empty($validated['lokasiMasalah'])) {
            foreach ($validated['lokasiMasalah'] as $lokasi) {
                RootCause::create([
                    'root_cause_name' => $lokasi,
                    'complaint_uuid' => $complaint->uuid,
                ]);
            }
        }

        // ✅ Optionally handle corrective actions later (you already have that relation)

        return redirect()->route('complaints.index')->with('success', 'Data komplain berhasil disimpan.');
    }

    public function update($uuid)
    {
        $complaint = Complaint::with(['root_causes'])->where('uuid', $uuid)->first();
        return view('complaints.update', [
            'complaint' => $complaint
        ]);
    }
}
