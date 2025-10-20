@extends('layouts.layout')
@section('title', 'Manajemen User')

@section('content')
<!-- Header -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Manajemen User</h2>
        <p class="text-gray-600 mt-1">Kelola akun pengguna dan hak akses sistem</p>
    </div>
    <a href="{{ route('users.create') }}"
        class="group bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
        <div
            class="w-6 h-6 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                </path>
            </svg>
        </div>
        <span class="font-semibold">Tambah User</span>
    </a>
</div>

<!-- Users Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-600 text-xs font-medium">Total User</p>
                <p class="text-xl font-bold text-blue-800" id="totalUsers">0</p>
            </div>
            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-600 text-xs font-medium">Top Manager</p>
                <p class="text-xl font-bold text-red-800" id="topManagerCount">0</p>
            </div>
            <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-600 text-xs font-medium">Manager</p>
                <p class="text-xl font-bold text-green-800" id="managerCount">0</p>
            </div>
            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-600 text-xs font-medium">Admin QC</p>
                <p class="text-xl font-bold text-yellow-800" id="adminQCCount">0</p>
            </div>
            <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-600 text-xs font-medium">Admin Dept</p>
                <p class="text-xl font-bold text-purple-800" id="adminDeptCount">0</p>
            </div>
            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-white shadow rounded-lg p-6">

    @if (session('success'))
    <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full text-left text-gray-700">
            <thead class="bg-gray-50 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Username</th>
                    <th class="px-4 py-3">Nama Lengkap</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Cabang</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $users->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $user->username }}</td>
                    <td class="px-4 py-3">{{ $user->name }}</td>

                    {{-- Role --}}
                    <td class="px-4 py-3">
                        @foreach ($user->roles as $role)
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if(Str::contains(strtolower($role->name), 'manager'))
                                    bg-green-100 text-green-700
                                @elseif(Str::contains(strtolower($role->name), 'admin'))
                                    bg-purple-100 text-purple-700
                                @else
                                    bg-yellow-100 text-yellow-700
                                @endif">
                            {{ $role->name }}
                        </span>
                        @endforeach
                    </td>

                    {{-- Cabang / Plant --}}
                    <td class="px-4 py-3">
                        @if($user->department && $user->department->plant_name)
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                            {{ $user->department->plant_name }}
                        </span>
                        @else
                        <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                            Semua Cabang
                        </span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-3">
                        @if($user->status == 1)
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                            Aktif
                        </span>
                        @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                            Inktif
                        </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('users.edit', $user->uuid) }}" class="text-blue-600 hover:underline">Edit</a>
                        @if($user->status == 1)
                        <a href="{{ route('users.update-status', $user->uuid) }}" class="text-yellow-600 hover:underline">Nonaktif</a>
                        @else
                        <a href="{{ route('users.update-status', $user->uuid) }}" class="text-yellow-600 hover:underline">Aktifkan</a>
                        @endif
                        <form action="{{ route('users.destroy', $user->uuid) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline"
                                onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada data user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection