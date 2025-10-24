<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\RootCause;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $year = Carbon::now()->year;
        $lastYear = $year - 1;

        // ✅ Komplain per bulan
        $monthlyComplaints = Complaint::selectRaw('MONTH(date) as month, COUNT(*) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // ✅ Komplain per bulan tahun lalu
        $lastYearComplaints = Complaint::selectRaw('MONTH(date) as month, COUNT(*) as total')
            ->whereYear('date', $lastYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // ✅ Susun data 12 bulan agar tidak ada bulan kosong
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'month' => Carbon::create()->month($i)->translatedFormat('M'),
                'total' => $monthlyComplaints[$i] ?? 0,
                'last_year' => $lastYearComplaints[$i] ?? 0,
            ];
        }

        // ✅ Statistik umum
        $totalComplaints = Complaint::count();
        $currentYearTotal = Complaint::whereYear('date', $year)->count();
        $previousYearTotal = Complaint::whereYear('date', $lastYear)->count();
        $investigatingComplaints = Complaint::where('status', 1)->count();
        $closedComplaints = Complaint::where('status', 2)->count();
        $monthlyComplaintsCount = Complaint::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->count();

        // ✅ Komplain terbaru
        $recentComplaints = Complaint::with('plant')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ✅ Distribusi per departemen (join root_cause + complaint)
        $departments = RootCause::select(
                'root_cause_name',
                DB::raw('SUM(CASE WHEN complaints.status = 0 THEN 1 ELSE 0 END) as open_count'),
                DB::raw('SUM(CASE WHEN complaints.status = 1 THEN 1 ELSE 0 END) as investigating_count'),
                DB::raw('SUM(CASE WHEN complaints.status = 2 THEN 1 ELSE 0 END) as closed_count'),
                DB::raw('COUNT(complaints.id) as total')
            )
            ->join('complaints', 'root_causes.complaint_uuid', '=', 'complaints.uuid')
            ->groupBy('root_cause_name')
            ->orderBy('root_cause_name')
            ->get();

        return view('dashboard.dashboard', compact(
            'year',
            'totalComplaints',
            'currentYearTotal',
            'previousYearTotal',
            'investigatingComplaints',
            'closedComplaints',
            'monthlyComplaintsCount',
            'recentComplaints',
            'months',
            'departments'
        ));
    }

}