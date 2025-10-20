@extends('layouts.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Add Complaint Button -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Data Komplain</h2>
            <p class="text-gray-600 mt-1">Kelola semua data komplain pelanggan</p>
        </div>
        <a href="{{ route('complaints.create') }}"
            class="group bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <div
                class="w-6 h-6 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
            </div>
            <span class="font-semibold">Tambah Komplain</span>
        </a>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">No</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Tanggal</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Produk</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Pelanggan</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Cabang</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Status</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody id="complaintsTableBody">
                    <tr>
                        <td class="py-4 px-6 text-sm text-gray-600" colspan="6">Belum ada data komplain</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Complaint Modal -->
<div id="complaintModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Tambah Komplain Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
            </div>
        </div>


    </div>
</div>
<!-- View Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Detail Komplain</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
            </div>
        </div>
        <div id="detailContent" class="p-6">
            <!-- Detail content will be populated here -->
        </div>
    </div>
</div>

@endsection