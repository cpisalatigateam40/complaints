@extends('layouts.layout')

@section('content')
<div>
    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Plant</h2>

        <a href="{{ route('plants.create') }}"
            class="group bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <div
                class="w-6 h-6 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
            </div>
            <span class="font-semibold">Tambah Plant</span>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="flex justify-end mb-4">
        <form action="{{ route('plants.index') }}" method="get" id="search-form" class="flex w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Cari Plant...">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-gray-50 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3 text-left">Plant</th>
                        <th class="px-4 py-3 text-left">Singkatan</th>
                        <th class="px-4 py-3 text-left">Departemen</th>
                        <th class="px-4 py-3 text-center w-64">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($plants as $plant)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center font-medium text-gray-700">
                            {{ ($plants->currentPage() - 1) * $plants->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-3">{{ $plant->plant }}</td>
                        <td class="px-4 py-3">{{ $plant->abbrivation ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <ul class="list-disc list-inside text-gray-700">
                                @foreach($plant->realDepartments as $department)
                                <li>{{ $department->department }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                <a href="{{ route('plants.edit', $plant->uuid) }}"
                                    class="inline-flex items-center px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="{{ route('plants.manage-department', $plant->uuid) }}"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-sitemap mr-1"></i> Manage
                                </a>
                                <!-- <a href="{{ route('plants.synchronize-plant', $plant->uuid) }}"
                                    class="inline-flex items-center px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                                    <i class="fas fa-sync-alt mr-1"></i> Sinkron
                                </a> -->
                                <form action="{{ route('plants.destroy', $plant->uuid) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus plant ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-red-600">
                            Data Plant belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            {{ $plants->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection