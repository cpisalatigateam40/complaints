@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div id="dashboardPage" class="fade-in">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <!-- Total Komplain Card -->
            <div
                class="group bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-4 border border-red-200 hover:border-red-300 transform hover:-translate-y-1 hover:scale-102">
                <div class="flex flex-col items-center text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-red-800 leading-none" id="totalComplaints">
                            {{ $totalComplaints }}
                        </p>
                        <p class="text-xs font-semibold text-red-700 uppercase tracking-wide">Total Komplain</p>
                        <div class="space-y-1">
                            <div class="flex items-center justify-center space-x-1 text-red-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-xs font-medium" id="currentYearTotal">
                                    Tahun ini: {{ number_format($currentYearTotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-center space-x-1 text-red-500">
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

            <!-- Sedang Diinvestigasi Card -->
            <div
                class="group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-4 border border-yellow-200 hover:border-yellow-300 transform hover:-translate-y-1 hover:scale-102">
                <div class="flex flex-col items-center text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-yellow-800 leading-none" id="investigatingComplaints">
                            {{ number_format($investigatingComplaints, 0, ',', '.') }}</p>
                        <p class="text-xs font-semibold text-yellow-700 uppercase tracking-wide">Sedang Diinvestigasi
                        </p>
                        <div class="flex items-center justify-center space-x-1 text-yellow-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="text-xs font-medium">Dalam Proses</span>
                        </div>
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
                            {{ number_format($closedComplaints, 0, ',', '.') }}</p>
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
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-6xl font-black text-blue-800 leading-none" id="monthlyComplaints">
                            {{ number_format($monthlyComplaintsCount, 0, ',', '.') }}</p>
                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Bulan Ini</p>
                        <div class="flex items-center justify-center space-x-1 text-blue-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z">
                                </path>
                            </svg>
                            <span class="text-xs font-medium">Periode Aktif</span>
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
                                {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyComplaintsChart');

    // Ambil data dari controller
    const months = @json(array_column($months, 'month'));
    const totals = @json(array_column($months, 'total'));
    const lastYearTotals = @json(array_column($months, 'last_year'));
    const totalThisYear = {{ $currentYearTotal }};
    const totalLastYear = {{ $previousYearTotal }};

    // Buat chart
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [...months, '{{ $year }}', '{{ $year - 1 }}'],
            datasets: [
                {
                    label: 'Data Bulanan',
                    data: [...totals, 0, 0],
                    backgroundColor: '#3b82f6'
                },
                {
                    label: 'Total Tahun Ini',
                    data: [...Array(12).fill(0), totalThisYear, 0],
                    backgroundColor: '#22c55e'
                },
                {
                    label: 'Total Tahun Lalu',
                    data: [...Array(12).fill(0), 0, totalLastYear],
                    backgroundColor: '#f97316'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>


@endsection