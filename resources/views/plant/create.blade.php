@extends('layouts.layout')

@section('content')
<!-- Page Heading -->
<h1 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Plant</h1>

<!-- Breadcrumb -->
<nav class="mb-6 text-sm">
    <ol class="flex space-x-2 text-gray-600">
        <li>
            <a href="{{ route('plants.index') }}" class="flex items-center hover:text-blue-600">
                <i class="fas fa-arrow-left mr-1"></i> Daftar Plant
            </a>
        </li>
        <li>/</li>
        <li class="text-gray-800 font-medium">Tambah</li>
    </ol>
</nav>

<!-- Card -->
<div class="bg-white shadow rounded-lg p-6">
    <form method="POST" action="{{ route('plants.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Plant -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">
                    Plant <span class="text-red-500">*</span>
                </label>
                <input type="text" name="plant" placeholder="Masukkan Nama Plant" value="{{ old('plant') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('plant') border-red-500 @enderror">

                @error('plant')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Singkatan -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">
                    Singkatan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="abbrivation" placeholder="Masukkan Singkatan Plant"
                    value="{{ old('abbrivation') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('abbrivation') border-red-500 @enderror">

                @error('abbrivation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex space-x-3">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                <i class="fa fa-save mr-1"></i> Simpan
            </button>
            <a href="{{ route('plants.index') }}"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                <i class="fa fa-times mr-1"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection