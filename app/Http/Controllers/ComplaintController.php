<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Plant;
use App\Models\Department;
use App\Models\CorrectiveAction;
use App\Models\DepartmentPlant;
use App\Models\Documentation;
use App\Models\Product;
use App\Models\RootCause;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        /**
         * =====================================================
         * 1. Reset filter when user clicks "Reset"
         * =====================================================
         */
        if ($request->reset == 1) {
            session()->forget([
                'filter_month',
                'filter_year',
                'filter_departmentplant',
                'filter_status',
                'filter_sort',
                'filter_direction',
            ]);

            return redirect()->route('complaints.index');
        }

        /**
         * =====================================================
         * 2. Handle Filters (smart handling for "" / null)
         * =====================================================
         */

        // MONTH
        if ($request->has('month')) {
            if ($request->month === null || $request->month === '') {
                session()->forget('filter_month');
                $month = null;
            } else {
                session(['filter_month' => $request->month]);
                $month = $request->month;
            }
        } else {
            $month = session('filter_month');
        }

        // YEAR
        if ($request->has('year')) {
            if ($request->year === null || $request->year === '') {
                session()->forget('filter_year');
                $year = null;
            } else {
                session(['filter_year' => $request->year]);
                $year = $request->year;
            }
        } else {
            $year = session('filter_year');
        }

        // DEPARTMENT
        if ($request->has('departmentplant')) {
            if ($request->departmentplant === null || $request->departmentplant === '') {
                session()->forget('filter_departmentplant');
                $filterDept = null;
            } else {
                session(['filter_departmentplant' => $request->departmentplant]);
                $filterDept = $request->departmentplant;
            }
        } else {
            $filterDept = session('filter_departmentplant');
        }

        // STATUS
        if ($request->has('status')) {
            if ($request->status === null || $request->status === '') {
                session()->forget('filter_status');
                $status = null;
            } else {
                session(['filter_status' => $request->status]);
                $status = $request->status;
            }
        } else {
            $status = session('filter_status');
        }

        // SORT & DIRECTION
        $sort = $request->sort ?? session('filter_sort', 'created_at');
        $direction = $request->direction ?? session('filter_direction', 'desc');

        session([
            'filter_sort'      => $sort,
            'filter_direction' => $direction,
        ]);

        /**
         * =====================================================
         * 3. Build Query
         * =====================================================
         */
        $departmentPlants = DepartmentPlant::with('department')->get();
        $departmentName = null;

        $query = Complaint::query();

        // ADMIN → only see complaints from their department
        if ($user->hasRole('Admin')) {
            $departmentName = $user->department->department->department ?? null;

            if ($departmentName) {
                $query->whereHas('root_causes', function ($q) use ($departmentName) {
                    $q->where('root_cause_name', $departmentName);
                });
            } else {
                $query->whereRaw('1 = 0'); // No department → no data
            }
        }

        // SUPERADMIN → filter by selected department
        if ($user->hasRole('Superadmin') && $filterDept) {
            $query->whereHas('root_causes', function ($q) use ($filterDept) {
                $q->where('root_cause_name', $filterDept);
            });
        }

        // APPLY FILTERS
        if ($month) {
            $query->whereMonth('date', $month);
        }

        if ($year) {
            $query->whereYear('date', $year);
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // SORTING
        $query->orderBy($sort, $direction);

        /**
         * =====================================================
         * 4. Pagination (keep query string)
         * =====================================================
         */
        $complaints = $query->paginate(10)->appends(request()->query());

        /**
         * =====================================================
         * 5. Summary Count
         * =====================================================
         */
        $total_complaints = Complaint::query()
            ->when($user->hasRole('Admin'), function ($q) use ($departmentName) {
                if ($departmentName) {
                    $q->whereHas('root_causes', function ($qa) use ($departmentName) {
                        $qa->where('root_cause_name', $departmentName);
                    });
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->when(
                $user->hasRole('Superadmin') && $filterDept,
                fn($q) => $q->whereHas('root_causes', fn($qa) => $qa->where('root_cause_name', $filterDept))
            )
            ->when($month, fn($q) => $q->whereMonth('date', $month))
            ->when($year, fn($q) => $q->whereYear('date', $year))
            ->when($status !== null && $status !== '', fn($q) => $q->where('status', $status))
            ->count();

        /**
         * =====================================================
         * 6. Return View
         * =====================================================
         */
        return view('complaints.index', compact(
            'complaints',
            'departmentPlants',
            'filterDept',
            'total_complaints',
            'month',
            'year',
            'status',
            'sort',
            'direction'
        ));
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
            'dokumentasi.*' => 'nullable|image|max:4096',
        ]);

        // ✅ Create complaint
        $complaint = Complaint::create([
            'date' => $validated['tanggal'],
            'product_arrival_date' => $validated['tanggalKedatangan'],
            'product_name' => $validated['namaProduk'],
            'production_code' => $validated['kodeProduksi'],
            'best_before' => $request->bestBefore,
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

        CorrectiveAction::create([
            'complaint_uuid' => $complaint->uuid,
            'short_term_ca' => $request->short_term_ca ?? NULL,
            'long_term_ca' => $request->long_term_ca ?? NULL,
            'causative_factor' => $request->causative_factor ?? NULL
        ]);

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

    public function insertCorrectiveAction(Request $request, $uuid)
    {
        $complaint = Complaint::firstWhere('uuid', $uuid);

        CorrectiveAction::updateOrCreate(
            ['complaint_uuid' => $complaint->uuid], // ← find by this
            [
                'short_term_ca' => $request->short_term_ca ?? null,
                'long_term_ca' => $request->long_term_ca ?? null,
                'causative_factor' => $request->causative_factor ?? null,
            ]
        );

        $complaint->status = 1;
        $complaint->notes = NULL;
        $complaint->save();

        return redirect()->route('complaints.index')->with('success', 'Data komplain berhasil disimpan.');
    }

    public function updateStatus(Request $request, $uuid)
    {
        $complaint = Complaint::where('uuid', $uuid)->firstOrFail();
        $complaint->status = $request->status;
        $complaint->save();

        return response()->json(['success' => true]);
    }

    public function complaintApprove($uuid)
    {
        $complaint = Complaint::where('uuid', $uuid)->firstOrFail();
        $complaint->status = '2';
        $complaint->save();

        return redirect()->route('complaints.index')->with('success', 'Data komplain berhasil diupdate.');
    }

    public function complaintReject(Request $request, $uuid)
    {
        $request->validate([
            'reject_note' => 'required|string'
        ]);

        $complaint = Complaint::where('uuid', $uuid)->firstOrFail();

        $complaint->update([
            'status' => '3',
            'reject_note' => $request->reject_note,
        ]);

        return redirect()->back()->with('success', 'Complaint berhasil ditolak');
    }
}
