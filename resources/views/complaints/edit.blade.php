@extends('layouts.layout')
@section('title', 'Edit Komplain')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Edit Komplain</h2>

    <form action="{{ route('complaints.update', $complaint->uuid) }}" method="POST" enctype="multipart/form-data"
        class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-800 border-b pb-2">Informasi Dasar</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Komplain</label>
                    <input type="date" name="tanggal"
                        value="{{ old('tanggal', \Carbon\Carbon::parse($complaint->date)->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border @error('tanggal') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('tanggal')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="namaProduk" value="{{ old('namaProduk', $complaint->product_name ?? '') }}"
                        class="w-full px-3 py-2 border @error('namaProduk') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('namaProduk')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Produksi</label>
                    <input type="text" name="kodeProduksi"
                        value="{{ old('kodeProduksi', $complaint->production_code) }}"
                        class="w-full px-3 py-2 border @error('kodeProduksi') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('kodeProduksi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Best Before</label>
                    <input type="date" name="bestBefore"
                        value="{{ old('bestBefore', \Carbon\Carbon::parse($complaint->best_before)->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border @error('bestBefore') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('bestBefore')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah yang Dikomplain</label>
                    <input type="number" name="jumlahKomplain"
                        value="{{ old('jumlahKomplain', $complaint->complaint_amount) }}"
                        class="w-full px-3 py-2 border @error('jumlahKomplain') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('jumlahKomplain')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Customer Info -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-800 border-b pb-2">Informasi Pelanggan</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kedatangan Produk</label>
                    <input type="date" name="tanggalKedatangan"
                        value="{{ old('tanggalKedatangan', \Carbon\Carbon::parse($complaint->product_arrival_date)->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border @error('tanggalKedatangan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('tanggalKedatangan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Ketidaksesuaian</label>
                    <textarea name="jenisKetidaksesuaian" rows="3"
                        class="w-full px-3 py-2 border @error('jenisKetidaksesuaian') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('jenisKetidaksesuaian', $complaint->nonconformity_type) }}</textarea>
                    @error('jenisKetidaksesuaian')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NCR</label>
                    <input type="text" name="ncr" value="{{ old('ncr', $complaint->ncr) }}"
                        class="w-full px-3 py-2 border @error('ncr') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('ncr')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Komplain</label>
                    <input type="file" name="dokumentasi" accept="image/*"
                        class="w-full px-3 py-2 border @error('dokumentasi') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @if($complaint->complaint_documentation)
                    <p class="text-sm text-gray-600 mt-2">File saat ini:
                        <a href="{{ asset('storage/'.$complaint->complaint_documentation) }}" target="_blank"
                            class="text-blue-600 hover:underline">Lihat</a>
                    </p>
                    @endif
                    @error('dokumentasi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                    <input type="text" name="pelanggan" value="{{ old('pelanggan', $complaint->customer) }}"
                        class="w-full px-3 py-2 border @error('pelanggan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('pelanggan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cabang</label>
                    <select name="cabang"
                        class="w-full px-3 py-2 border @error('cabang') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Pilih cabang</option>
                        @foreach ($plants as $plant)
                        <option value="{{ $plant->uuid }}"
                            {{ old('cabang', $complaint->plant_uuid) == $plant->uuid ? 'selected' : '' }}>
                            {{ $plant->plant }}
                        </option>
                        @endforeach
                    </select>
                    @error('cabang')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penyampaian</label>
                    <select name="penyampaian"
                        class="w-full px-3 py-2 border @error('penyampaian') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Pilih cara penyampaian</option>
                        <option value="1" {{ old('penyampaian', $complaint->delivery) == '1' ? 'selected' : '' }}>Email
                        </option>
                        <option value="2" {{ old('penyampaian', $complaint->delivery) == '2' ? 'selected' : '' }}>
                            Telepon</option>
                        <option value="3" {{ old('penyampaian', $complaint->delivery) == '3' ? 'selected' : '' }}>
                            WhatsApp</option>
                        <option value="4" {{ old('penyampaian', $complaint->delivery) == '4' ? 'selected' : '' }}>
                            Langsung</option>
                    </select>
                    @error('penyampaian')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Root Cause Analysis -->
        <div class="space-y-4">
            <h4 class="font-medium text-gray-800 border-b pb-2">Analisis Akar Masalah</h4>
            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Akar Masalah</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @php
                $selectedRootCauses = $complaint->root_causes->pluck('root_cause_name')->toArray();
                @endphp

                @foreach ($departments as $dept)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="lokasiMasalah[]" value="{{ $dept->uuid }}"
                        {{ in_array($dept->department, old('lokasiMasalah', $selectedRootCauses)) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">{{ $dept->department }}</span>
                </label>
                @endforeach

            </div>
            @error('lokasiMasalah')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Corrective Action Section -->
        <div class="space-y-4 mt-6">
            <h4 class="font-medium text-gray-800 border-b pb-2">Tindakan Perbaikan</h4>

            <!-- Faktor Penyebab -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Faktor Penyebab</label>
                <textarea name="causative_factor" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('causative_factor', $complaint->corrective_actions->causative_factor ?? '') }}</textarea>
            </div>

            <!-- Tindakan Perbaikan Jangka Pendek -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan Perbaikan Jangka Pendek</label>
                <textarea name="short_term_ca" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('short_term_ca', $complaint->corrective_actions->short_term_ca ?? '') }}</textarea>
            </div>

            <!-- Tindakan Perbaikan Jangka Panjang -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tindakan Perbaikan Jangka Panjang</label>
                <textarea name="long_term_ca" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('long_term_ca', $complaint->corrective_actions->long_term_ca ?? '') }}</textarea>
            </div>
        </div>


        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('complaints.index') }}"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Update
            </button>
        </div>
    </form>
</div>
@endsection