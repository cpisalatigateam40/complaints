<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Plant;
use App\Models\Department;
use App\Models\CorrectiveAction;
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
        $plants = Plant::orderBy('plant', 'asc')->get();
        $departments = Department::orderBy('department')->get();
        
        return view('complaints.create', [
            'plants' => $plants,
            'departments' => $departments,
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

            'causative_factor' => 'required|string',
            'short_term_ca' => 'required|string',
            'long_term_ca' => 'required|string',
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
            'product_name' => $validated['namaProduk'], // You can set product UUID if available
            'production_code' => $validated['kodeProduksi'],
            'best_before' => $validated['bestBefore'],
            'complaint_amount' => $validated['jumlahKomplain'],
            'nonconformity_type' => $validated['jenisKetidaksesuaian'],
            'ncr' => $validated['ncr'] ?? null,
            'complaint_documentation' => $filePath,
            'customer' => $validated['pelanggan'],
            'plant_uuid' => $validated['cabang'],
            'delivery' => $validated['penyampaian'],
            'status' => '0',
        ]);

        if (!empty($validated['lokasiMasalah'])) {
            foreach ($validated['lokasiMasalah'] as $deptUuid) {
                $department = Department::where('uuid', $deptUuid)->first();

                RootCause::create([
                    'root_cause_name' => $department ? $department->department : 'Unknown',
                    'complaint_uuid' => $complaint->uuid,
                ]);
            }
        }

        CorrectiveAction::create([
            'causative_factor' => $validated['causative_factor'],
            'short_term_ca' => $validated['short_term_ca'],
            'long_term_ca' => $validated['long_term_ca'],
            'complaint_uuid' => $complaint->uuid,
        ]);

        // ✅ Optionally handle corrective actions later (you already have that relation)

        return redirect()->route('complaints.index')->with('success', 'Data komplain berhasil disimpan.');
    }


    public function show($uuid)
    {
        $complaint = Complaint::with([ 'plant', 'root_causes'])
        ->where('uuid', $uuid)
        ->firstOrFail();


        return view('complaints.partials.detail', compact('complaint'));
    }

    public function destroy($uuid)
    {
        $complaint = Complaint::where('uuid', $uuid)->firstOrFail();

        // 🔹 Hapus relasi root causes jika ada
        if ($complaint->root_causes()->exists()) {
            $complaint->root_causes()->delete();
        }

        // 🔹 Hapus relasi corrective action jika ada
        if ($complaint->corrective_actions()->exists()) {
            $complaint->corrective_actions()->delete();
        }

        // 🔹 Hapus file dokumentasi jika ada
        if ($complaint->complaint_documentation && \Storage::disk('public')->exists($complaint->complaint_documentation)) {
            \Storage::disk('public')->delete($complaint->complaint_documentation);
        }

        // 🔹 Hapus complaint-nya sendiri
        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Data komplain berhasil dihapus.');
    }


    public function edit($uuid)
    {
        $complaint = Complaint::with('root_causes', 'corrective_actions')->where('uuid', $uuid)->firstOrFail();
        $plants = Plant::all();
        $departments = Department::all();

        return view('complaints.edit', compact('complaint', 'plants', 'departments'));
    }

    public function update(Request $request, $uuid)
    {
        // ✅ Cari data komplain
        $complaint = Complaint::where('uuid', $uuid)->firstOrFail();

        // ✅ Validasi input
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
            'causative_factor' => 'nullable|string',
            'short_term_ca' => 'nullable|string',
            'long_term_ca' => 'nullable|string',
        ]);

        // ✅ Handle upload file baru (hapus file lama jika ada)
        $filePath = $complaint->complaint_documentation; // default pakai file lama
        if ($request->hasFile('dokumentasi')) {
            // Hapus file lama jika ada
            if ($filePath && \Storage::disk('public')->exists($filePath)) {
                \Storage::disk('public')->delete($filePath);
            }

            $file = $request->file('dokumentasi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('complaint_docs', $filename, 'public');
        }

        // ✅ Update data utama
        $complaint->update([
            'date' => $validated['tanggal'],
            'product_arrival_date' => $validated['tanggalKedatangan'],
            'product_name' => $validated['namaProduk'],
            'production_code' => $validated['kodeProduksi'],
            'best_before' => $validated['bestBefore'],
            'complaint_amount' => $validated['jumlahKomplain'],
            'nonconformity_type' => $validated['jenisKetidaksesuaian'],
            'ncr' => $validated['ncr'] ?? null,
            'complaint_documentation' => $filePath,
            'customer' => $validated['pelanggan'],
            'plant_uuid' => $validated['cabang'],
            'delivery' => $validated['penyampaian'],
        ]);

        // ✅ Update relasi root cause (hapus lama, buat baru)
        $complaint->root_causes()->delete();

        if (!empty($validated['lokasiMasalah'])) {
            foreach ($validated['lokasiMasalah'] as $deptUuid) {
                $department = Department::where('uuid', $deptUuid)->first();

                RootCause::create([
                    'root_cause_name' => $department ? $department->department : 'Unknown',
                    'complaint_uuid' => $complaint->uuid,
                ]);
            }
        }

        if ($complaint->corrective_action) {
        $complaint->corrective_action->update([
            'causative_factor' => $validated['causative_factor'] ?? '',
            'short_term_ca' => $validated['short_term_ca'] ?? '',
            'long_term_ca' => $validated['long_term_ca'] ?? '',
        ]);
        } else {
            CorrectiveAction::create([
                'complaint_uuid' => $complaint->uuid,
                'causative_factor' => $validated['causative_factor'] ?? '',
                'short_term_ca' => $validated['short_term_ca'] ?? '',
                'long_term_ca' => $validated['long_term_ca'] ?? '',
            ]);
        }

        return redirect()
            ->route('complaints.index')
            ->with('success', 'Data komplain berhasil diperbarui.');
    }






}