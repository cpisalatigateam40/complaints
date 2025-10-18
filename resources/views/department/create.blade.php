@extends('layouts.layout')

@section('content')
<div class="px-6 py-6">
    <!-- Judul Halaman -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Departemen</h1>

    <!-- Breadcrumb -->
    <nav class="text-sm mb-6" aria-label="Breadcrumb">
        <ol class="list-reset flex text-gray-600 space-x-2">
            <li>
                <a href="{{ route('departments.index') }}" class="hover:text-blue-600 flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Daftar Departemen
                </a>
            </li>
            <li>/</li>
            <li class="text-gray-400">Tambah</li>
        </ol>
    </nav>

    <!-- Card -->
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('departments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Form Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Departemen -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Departemen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="department"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('department') border-red-500 @enderror"
                        placeholder="Masukkan Nama Departemen" value="{{ old('department') }}">
                    @error('department')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Singkatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Singkatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="abbrivation"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('abbrivation') border-red-500 @enderror"
                        placeholder="Masukkan Singkatan Departemen" value="{{ old('abbrivation') }}">
                    @error('abbrivation')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('departments.index') }}"
                    class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa fa-times mr-1"></i> Batal
                </a>
                <button type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fa fa-save mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection