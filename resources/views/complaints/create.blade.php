@extends('layouts.layout')
@section('title', 'Tambah Data Komplain')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Tambah Data Komplain</h2>

    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Basic Info -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-800 border-b pb-2">Informasi Dasar</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Komplain</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                        class="w-full px-3 py-2 border @error('tanggal') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('tanggal')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="namaProduk" value="{{ old('namaProduk') }}"
                        class="w-full px-3 py-2 border @error('namaProduk') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('namaProduk')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kode Produksi</label>
                    <input type="text" name="kodeProduksi" value="{{ old('kodeProduksi') }}"
                        class="w-full px-3 py-2 border @error('kodeProduksi') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('kodeProduksi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Best Before</label>
                    <input type="date" name="bestBefore" value="{{ old('bestBefore') }}"
                        class="w-full px-3 py-2 border @error('bestBefore') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('bestBefore')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <!-- Input jumlah -->
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah yang Dikomplain</label>
                        <input type="number" name="jumlahKomplain" value="{{ old('jumlahKomplain') }}"
                            class="w-full px-3 py-2 border @error('jumlahKomplain') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        @error('jumlahKomplain')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Select satuan -->
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Satuan</label>
                        <select name="unit"
                            class="w-full px-3 py-2 border @error('unit') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">-- Pilih Satuan --</option>
                            <option value="PCS" {{ old('unit') == 'PCS' ? 'selected' : '' }}>PCS</option>
                            <option value="GR" {{ old('unit') == 'GR' ? 'selected' : '' }}>GR</option>
                            <option value="KG" {{ old('unit') == 'KG' ? 'selected' : '' }}>KG</option>
                            <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box</option>
                            <option value="Pack" {{ old('unit') == 'Pack' ? 'selected' : '' }}>Pack</option>
                            <option value="Karung" {{ old('unit') == 'Karung' ? 'selected' : '' }}>Karung</option>
                        </select>
                        @error('unit')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- Customer Info -->
            <div class="space-y-4">
                <h4 class="font-medium text-gray-800 border-b pb-2">Informasi Pelanggan</h4>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kedatangan Produk</label>
                    <input type="date" name="tanggalKedatangan" value="{{ old('tanggalKedatangan') }}"
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
                        required>{{ old('jenisKetidaksesuaian') }}</textarea>
                    @error('jenisKetidaksesuaian')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NCR</label>
                    <input type="text" name="ncr" value="{{ old('ncr') }}"
                        class="w-full px-3 py-2 border @error('ncr') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('ncr')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Komplain</label>
                    <input type="file" name="dokumentasi" accept="image/*"
                        class="w-full px-3 py-2 border @error('dokumentasi') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('dokumentasi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div> -->

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dokumentasi Komplain</label>
                    <input type="file" name="dokumentasi[]" accept="image/*" multiple
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        onchange="previewImages(event)">
                    @error('dokumentasi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <div id="imagePreview" class="mt-2 flex flex-wrap gap-2"></div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pelanggan</label>
                    <input type="text" name="pelanggan" value="{{ old('pelanggan') }}"
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
                        <option value="{{ $plant->uuid }}" {{ old('cabang') == $plant->uuid ? 'selected' : '' }}>
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
                        <option value="1" {{ old('penyampaian')=='1'?'selected':'' }}>Email</option>
                        <option value="2" {{ old('penyampaian')=='2'?'selected':'' }}>Telepon</option>
                        <option value="3" {{ old('penyampaian')=='3'?'selected':'' }}>WhatsApp</option>
                        <option value="4" {{ old('penyampaian')=='4'?'selected':'' }}>Langsung</option>
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
                @foreach ($departments as $dept)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="lokasiMasalah[]" value="{{ $dept->uuid }}"
                        {{ (is_array(old('lokasiMasalah')) && in_array($dept->uuid, old('lokasiMasalah'))) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">{{ $dept->department }}</span>
                </label>
                @endforeach
            </div>
            @error('lokasiMasalah')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('complaints.index') }}"
                class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
let allFiles = []; // menampung semua file yg dipilih

function previewImages(event) {
    const files = Array.from(event.target.files);
    allFiles = allFiles.concat(files);

    // reset input supaya bisa pilih file yang sama lagi
    event.target.value = '';

    renderPreview();
}

function renderPreview() {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    allFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            const container = document.createElement('div');
            container.className = 'relative';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-24 h-24 object-cover rounded border';

            // tombol hapus
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.innerHTML = '&times;';
            btn.className =
                'absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center';
            btn.onclick = () => {
                allFiles.splice(index, 1); // hapus file dari array
                renderPreview(); // rerender preview
            };

            container.appendChild(img);
            container.appendChild(btn);
            preview.appendChild(container);
        }
        reader.readAsDataURL(file);
    });
}
</script>
@endsection