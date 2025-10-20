@extends('layouts.layout')
@section('title', 'Tambah User')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Tambah User Baru</h2>

    <form action="{{ route('complaints.store') }}" method="POST" class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-800 border-b pb-2">Informasi Dasar</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Komplain</label>
                    <span>{{$complaint->date}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <span>{{$complaint->product->product_name}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Produksi</label>
                    <span>{{$complaint->production_code}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Best Before</label>
                    <span>{{$complaint->best_before}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah yang Dikomplain</label>
                    <span>{{$complaint->complaint_amount}}</span>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-800 border-b pb-2">Informasi Pelanggan</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kedatangan Produk</label>
                    <span>{{$complaint->product_arrival_date}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Ketidaksesuaian</label>
                    <span>{{$complaint->nonconfirmity_type}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NCR</label>
                    <span>{{$complaint->ncr}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Komplain</label>
                    <button></button>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                    <span>{{$complaint->customer}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cabang</label>
                    <span>{{$complaint->plant->plant}}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penyampaian</label>
                    @php
                    $deliveryMethods = [
                    1 => 'Email',
                    2 => 'Telepon',
                    3 => 'WhatsApp',
                    4 => 'Langsung',
                    ];
                    @endphp

                    <span class="inline-block px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800">
                        {{ $deliveryMethods[$complaint->delivery] ?? '-' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Root Cause Analysis -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-800 border-b pb-2">Analisis Akar Masalah</h4>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Lokasi Akar Masalah
                </label>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @forelse($complaint->root_causes as $cause)
                    <span class="flex items-center space-x-2 bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ $cause->root_cause_name }}</span>
                    </span>
                    @empty
                    <span class="text-gray-500 text-sm">Tidak ada lokasi akar masalah</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Corrective Actions -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Faktor Penyebab</label>
                <textarea id="faktorPenyebab" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <h4 class="font-medium text-gray-800 border-b pb-2">Tindakan Perbaikan</h4>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan Perbaikan Jangka Pendek</label>
                <textarea id="tindakanPendek" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan Perbaikan Jangka Panjang</label>
                <textarea id="tindakanPanjang" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <button type="button" onclick="closeModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection