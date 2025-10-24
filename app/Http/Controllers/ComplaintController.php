<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Plant;
use App\Models\Department;
use App\Models\CorrectiveAction;
use App\Models\Documentation;
use App\Models\Product;
use App\Models\RootCause;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::orderBy('created_at', 'desc')->paginate(10);

        return view('complaints.index', [
            'complaints' => $complaints
        ]);
    }

    public function create()
    {
        $plants = Plant::orderBy('plant', 'asc')->get();
        $departments = Department::where('department', '!=', 'Quality Control')->orderBy('department')->get();

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
            'tanggalKedatangan' => 'nullable|date',
            'namaProduk' => 'required|string|max:255',
            'kodeProduksi' => 'nullable|string|max:255',
            'unit' => 'required|string|max:255',
            'bestBefore' => 'nullable|date',
            'jumlahKomplain' => 'required|integer|min:1',
            'jenisKetidaksesuaian' => 'required|string',
            'ncr' => 'nullable|string|max:255',
            'pelanggan' => 'required|string|max:255',
            'cabang' => 'required|string|max:255',
            'penyampaian' => 'required|string|max:50',
            'lokasiMasalah' => 'nullable|array',
            'lokasiMasalah.*' => 'string',
            'dokumentasi.*' => 'nullable|image|max:4096', // ✅ multiple files
        ]);

        // ✅ Create complaint
        $complaint = Complaint::create([
            'date' => $validated['tanggal'],
            'product_arrival_date' => $validated['tanggalKedatangan'],
            'product_name' => $validated['namaProduk'],
            'production_code' => $validated['kodeProduksi'],
            'best_before' => $validated['bestBefore'],
            'complaint_amount' => $validated['jumlahKomplain'],
            'unit' => $validated['unit'],
            'nonconformity_type' => $validated['jenisKetidaksesuaian'],
            'ncr' => $validated['ncr'] ?? null,
            'customer' => $validated['pelanggan'],
            'plant_uuid' => $validated['cabang'],
            'delivery' => $validated['penyampaian'],
            'status' => '0',
        ]);

        // ✅ Save related root causes (departments)
        if (!empty($validated['lokasiMasalah'])) {
            foreach ($validated['lokasiMasalah'] as $deptUuid) {
                $department = Department::where('uuid', $deptUuid)->first();

                RootCause::create([
                    'root_cause_name' => $department ? $department->department : 'Unknown',
                    'complaint_uuid' => $complaint->uuid,
                ]);
            }
        }

        // ✅ Handle multiple file uploads
        if ($request->hasFile('dokumentasi')) {
            // Buat folder berdasarkan UUID komplain
            $folderName = 'complaint_docs/' . $complaint->uuid;

            foreach ($request->file('dokumentasi') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();

                    // Simpan ke dalam folder berdasarkan UUID
                    $filePath = $file->storeAs($folderName, $filename, 'public');

                    // Simpan ke tabel documentation
                    Documentation::create([
                        'complaint_uuid' => $complaint->uuid,
                        'filename' => $filename,
                        'path' => $filePath, // simpan path full (misalnya: complaint_docs/uuid/file.jpg)
                    ]);
                }
            }
        }

        return redirect()->route('complaints.index')->with('success', 'Data komplain berhasil disimpan.');
    }



    public function showComplaints($uuid)
    {
        $complaint = Complaint::with(['plant', 'root_causes', 'documentations'])
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
        if ($complaint->corrective_action()->exists()) {
            $complaint->corrective_action()->delete();
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
        $complaint = Complaint::with('root_causes', 'corrective_action')->where('uuid', $uuid)->firstOrFail();
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
            'unit' => 'required|string|max:255',
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
            'unit' => $validated['unit'],
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

    public function updateData($uuid)
    {
        $complaint = Complaint::with('root_causes', 'corrective_action')->where('uuid', $uuid)->firstOrFail();
        $plants = Plant::all();
        $departments = Department::all();

        return view('complaints.update', compact('complaint', 'plants', 'departments'));
    }

    public function updateStatus(Request $request, $uuid)
    {
        $complaint = Complaint::where('uuid', $uuid)->firstOrFail();
        $complaint->status = $request->status;
        $complaint->save();

        return response()->json(['success' => true]);
    }

}