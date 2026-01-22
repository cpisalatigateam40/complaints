@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div id="dashboardPage" class="fade-in">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <form method="GET" action="{{ route('dashboard.index') }}" class="mb-6" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Filter Month -->
                <div>
                    <label class="text-sm font-semibold">Bulan</label>
                    <select name="filter_month" class="w-full border rounded px-3 py-2"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Year -->
                <div>
                    <label class="text-sm font-semibold">Tahun</label>
                    <select name="filter_year" class="w-full border rounded px-3 py-2"
                        onchange="document.getElementById('filterForm').submit()">
                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                        @endfor
                    </select>
                </div>

                <!-- Filter Department -->
                @role('Superadmin')
                <div>
                    <label class="text-sm font-semibold">Departemen</label>
                    <select name="filter_department" class="w-full border rounded px-3 py-2"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="">-- Semua Departemen --</option>
                        @foreach ($departmentPlants as $dp)
                        <option value="{{ $dp->department->department }}"
                            {{ $filterDepartment == $dp->department->department ? 'selected' : '' }}>
                            {{ $dp->department->department }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endrole

                <!-- REMOVE THE BUTTON if you want pure auto-refresh -->
                {{-- <div class="flex items-end">
            <button type="submit"
                class="w-full bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700 transition">
                Apply Filter
            </button>
        </div> --}}
            </div>
        </form>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <!-- Total Komplain Card -->
            <div
                class="group bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-4 border border-red-200 hover:border-red-300 transform hover:-translate-y-1 hover:scale-102">
                <div class="flex flex-col items-center text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M12 9v2m0 4h.01M5.455 19h13.09c1.32 0 2.15-1.43 1.49-2.63L13.49 4.89c-.66-1.2-2.32-1.2-2.98 0L3.965 16.37c-.66 1.2.17 2.63 1.49 2.63z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-red-800 leading-none" id="monthlyComplaints">
                            {{ number_format($monthlyComplaintsCount, 0, ',', '.') }}
                        </p>
                        <p class="text-xs font-semibold text-red-700 uppercase tracking-wide">OPEN</p>
                    </div>
                </div>
            </div>

            <!-- Sedang Diinvestigasi Card -->
            <div onclick="window.location.href='{{ route('complaints.index', [
        'month' => request('filter_month'),
        'year' => request('filter_year'),
        'status' => 1
    ]) }}'"
                class="group cursor-pointer bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-4 border border-yellow-200 hover:border-yellow-300 transform hover:-translate-y-1 hover:scale-102">

                <div class="flex flex-col items-center text-center space-y-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-yellow-800 leading-none">
                            {{ number_format($investigatingComplaints, 0, ',', '.') }}
                        </p>
                        <p class="text-xs font-semibold text-yellow-700 uppercase tracking-wide">Sedang Diinvestigasi</p>
                    </div>
                </div>
            </div>

            <!-- Selesai Card -->
            <div
                class="group bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-4 border border-green-200 hover:border-green-300 transform hover:-translate-y-1 hover:scale-102">
                <div class="flex flex-col items-center text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-green-800 leading-none" id="closedComplaints">
                            {{ number_format($closedComplaints, 0, ',', '.') }}
                        </p>
                        <p class="text-xs font-semibold text-green-700 uppercase tracking-wide">Selesai</p>
                        <div class="flex items-center justify-center space-x-1 text-green-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-xs font-medium">Terselesaikan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulan Ini Card -->
            <div
                class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-4 border border-blue-200 hover:border-blue-300 transform hover:-translate-y-1 hover:scale-102">
                <div class="flex flex-col items-center text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-blue-800 leading-none" id="totalComplaints">
                            {{ $totalComplaints }}
                        </p>
                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Total Komplain</p>
                        <div class="space-y-1">
                            <div class="flex items-center justify-center space-x-1 text-blue-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium" id="currentYearTotal">
                                    Tahun ini: {{ number_format($currentYearTotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-center space-x-1 text-blue-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xs font-medium" id="previousYearTotal">
                                    Tahun lalu: {{ number_format($previousYearTotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Monthly Complaints Chart -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Total Komplain per Bulan - {{ $year }}
                    </h3>
                </div>

                <canvas id="monthlyComplaintsChart" height="100"></canvas>

                <div class="flex justify-center mt-4 space-x-6 text-sm">
                    <div class="flex items-center space-x-2 text-blue-600">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span><span>Data Bulanan</span>
                    </div>
                    <div class="flex items-center space-x-2 text-green-600">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span><span>Total Tahun Ini</span>
                    </div>
                    <div class="flex items-center space-x-2 text-orange-500">
                        <span class="w-3 h-3 rounded-full bg-orange-400"></span><span>Total Tahun Lalu</span>
                    </div>
                </div>
            </div>

            <!-- Combined Status & Department Distribution -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Distribusi Status Komplain per Departemen</h3>
                    <div class="flex space-x-4 text-xs">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-gray-600">Open</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-gray-600">Investigasi</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-gray-600">Close</span>
                        </div>
                    </div>
                </div>

                <div id="statusDepartmentChart" class="space-y-6">
                    @foreach ($departments as $dept)
                    @php
                    $openPercent = $dept->total > 0 ? round(($dept->open_count / $dept->total) * 100, 1) : 0;
                    $investigatingPercent = $dept->total > 0 ? round(($dept->investigating_count / $dept->total) * 100, 1) : 0;
                    $closedPercent = $dept->total > 0 ? round(($dept->closed_count / $dept->total) * 100, 1) : 0;
                    @endphp

                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold text-gray-800">{{ $dept->root_cause_name }}</h4>
                            <span class="text-sm text-gray-500">Total: {{ $dept->total }}</span>
                        </div>

                        <!-- Progress bar -->
                        <div class="relative w-full h-3 bg-gray-100 rounded-full overflow-hidden mb-2">
                            <!-- Open -->
                            <div class="absolute top-0 left-0 h-full bg-red-500"
                                style="width: {{ $openPercent }}%; transition: width 0.5s ease;"></div>

                            <!-- Investigasi -->
                            <div class="absolute top-0 h-full bg-yellow-400"
                                style="left: {{ $openPercent }}%; width: {{ $investigatingPercent }}%; transition: width 0.5s ease;"></div>

                            <!-- Close -->
                            <div class="absolute top-0 h-full bg-green-500"
                                style="left: calc({{ $openPercent }}% + {{ $investigatingPercent }}%); width: {{ $closedPercent }}%; transition: width 0.5s ease;"></div>
                        </div>


                        <div class="text-sm text-gray-700 flex justify-between">
                            <div>Open:
                                <span class="font-semibold text-red-600">{{ $dept->open_count }}</span>
                                <span class="text-gray-500">({{ $openPercent }}%)</span>
                            </div>
                            <div>Investigasi:
                                <span class="font-semibold text-yellow-600">{{ $dept->investigating_count }}</span>
                                <span class="text-gray-500">({{ $investigatingPercent }}%)</span>
                            </div>
                            <div>Close:
                                <span class="font-semibold text-green-600">{{ $dept->closed_count }}</span>
                                <span class="text-gray-500">({{ $closedPercent }}%)</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Komplain Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-medium text-gray-600">No</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600">Tanggal</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600">Produk</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600">Pelanggan</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600">Cabang</th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody id="recentComplaintsTable">
                        @forelse ($recentComplaints as $index => $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($item->date)->format('d-M-Y') }}
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $item->product_name }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $item->customer }}</td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $item->plant->plant ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">
                                @if ($item->status == 0)
                                <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Open</span>
                                @elseif ($item->status == 1)
                                <span
                                    class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Investigasi</span>
                                @elseif ($item->status == 2)
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Selesai</span>
                                @else
                                <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">Unknown</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4 text-sm text-gray-600 text-center" colspan="6">
                                Belum ada data komplain
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@include('complaints.partials.chart-script')
@endsection