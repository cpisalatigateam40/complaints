<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\DepartmentPlant;
use App\Models\RootCause;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // -----------------------------
        // FILTER INPUT
        // -----------------------------
        $year = $request->get('filter_year', Carbon::now()->year);
        $month = $request->get('filter_month', null);
        $filterDepartment = $request->get('filter_department', null);
        $departmentPlants = DepartmentPlant::with('department')->get();

        $lastYear = $year - 1;

        // -----------------------------
        // DEPARTMENT NAME (Admin Only)
        // -----------------------------
        $departmentName = null;
        if ($user->hasRole('Admin')) {
            $departmentName = $user->department->department->department ?? null;
        }

        // -----------------------------
        // BASE QUERY
        // -----------------------------
        $complaintQuery = Complaint::query();

        // Filter: Admin department
        if ($departmentName) {
            $complaintQuery->whereHas('root_causes', function ($q) use ($departmentName) {
                $q->where('root_cause_name', $departmentName);
            });
        }

        // Filter: Department user pilih
        if ($filterDepartment) {
            $complaintQuery->whereHas('root_causes', function ($q) use ($filterDepartment) {
                $q->where('root_cause_name', $filterDepartment);
            });
        }

        // Filter: Bulan (jika ada)
        if ($month) {
            $complaintQuery->whereMonth('date', $month);
        }

        // -----------------------------
        // MONTHLY DATA (Current Year)
        // -----------------------------
        $monthlyComplaints = (clone $complaintQuery)
            ->selectRaw('MONTH(date) as month, COUNT(*) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $lastYearComplaints = (clone $complaintQuery)
            ->selectRaw('MONTH(date) as month, COUNT(*) as total')
            ->whereYear('date', $lastYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Build 12 months list
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'month'      => Carbon::create()->month($i)->translatedFormat('M'),
                'total'      => $monthlyComplaints[$i] ?? 0,
                'last_year'  => $lastYearComplaints[$i] ?? 0,
            ];
        }

        // -----------------------------
        // GENERAL STATISTICS
        // -----------------------------
        $totalComplaints = (clone $complaintQuery)->count();
        $currentYearTotal = (clone $complaintQuery)->whereYear('date', $year)->count();
        $previousYearTotal = (clone $complaintQuery)->whereYear('date', $lastYear)->count();

        $investigatingComplaints = (clone $complaintQuery)->where('status', 1)->count();
        $closedComplaints = (clone $complaintQuery)->where('status', 2)->count();

        $monthlyComplaintsCount = (clone $complaintQuery)->where('status', 0)->orWhere('status', 3)->count();

        // -----------------------------
        // RECENT COMPLAINTS
        // -----------------------------
        $recentComplaints = (clone $complaintQuery)
            ->with('plant')
            ->latest()
            ->take(5)
            ->get();

        // -----------------------------
        // DEPARTMENT DISTRIBUTION
        // -----------------------------
        $departments = RootCause::select(
            'root_cause_name',
            DB::raw('SUM(CASE WHEN complaints.status = 0 THEN 1 ELSE 0 END) as open_count'),
            DB::raw('SUM(CASE WHEN complaints.status = 1 THEN 1 ELSE 0 END) as investigating_count'),
            DB::raw('SUM(CASE WHEN complaints.status = 2 THEN 1 ELSE 0 END) as closed_count'),
            DB::raw('COUNT(complaints.id) as total')
        )
            ->join('complaints', 'root_causes.complaint_uuid', '=', 'complaints.uuid')
            ->when($departmentName, fn($q) => $q->where('root_cause_name', $departmentName))
            ->groupBy('root_cause_name')
            ->orderBy('root_cause_name')
            ->get();

        // List department untuk filter dropdown
        $departmentList = RootCause::select('root_cause_name')
            ->groupBy('root_cause_name')
            ->orderBy('root_cause_name')
            ->pluck('root_cause_name');

        return view('dashboard.dashboard', compact(
            'year',
            'month',
            'months',
            'totalComplaints',
            'currentYearTotal',
            'previousYearTotal',
            'investigatingComplaints',
            'closedComplaints',
            'monthlyComplaintsCount',
            'recentComplaints',
            'departments',
            'departmentPlants',
            'filterDepartment'
        ));
    }
}
