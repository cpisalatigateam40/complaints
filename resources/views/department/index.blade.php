@extends('layouts.layout')

@section('content')
<div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Department</h2>

        <a href="{{ route('departments.create') }}"
            class="group bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <div
                class="w-6 h-6 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
            </div>
            <span class="font-semibold">Tambah Department</span>
        </a>

    </div>

    <!-- Card -->
    <div class="bg-white shadow rounded-lg">
        <!-- Search Bar -->
        <div class="p-4 border-b border-gray-200">
            <form action="{{ route('departments.index') }}" method="get" class="flex justify-end">
                <div class="relative w-full max-w-xs">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Departemen..."
                        class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-x-auto m-6">
            <table class="min-w-full text-left text-gray-700">
                <thead class="bg-gray-50 text-gray-700 font-semibold">
                    <tr class="text-center">
                        <th class="px-4 py-2 w-12">No</th>
                        <th class="px-4 py-2 text-left">Department</th>
                        <th class="px-4 py-2 text-left">Singkatan</th>
                        <th class="px-4 py-2 text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($departments as $department)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-center">
                            {{ ($departments->currentPage() - 1) * $departments->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-2">{{ $department->department }}</td>
                        <td class="px-4 py-2">{{ $department->abbrivation }}</td>


                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('departments.edit', $department->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                                    <i class="fas fa-edit">Edit</i>
                                </a>
                                <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus department ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        <i class="fas fa-trash">Hapus</i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                            Data department belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-200">
            {{ $departments->links('pagination::tailwind') }}
        </div>
    </div>

</div>
@endsection