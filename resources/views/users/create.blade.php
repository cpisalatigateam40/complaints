@extends('layouts.layout')
@section('title', 'Tambah User')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Tambah User Baru</h2>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                <input type="text" id="userUsername"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                <p class="text-xs text-gray-500 mt-1">Username harus unik dan tidak boleh sama</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" id="userFullName"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                <div class="relative">
                    <input type="password" id="userPassword"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pr-12"
                        required>
                    <button type="button" onclick="toggleUserPassword()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg id="userEyeIcon" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                <select id="userRole"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="">Pilih Role</option>
                    <option value="Top Manager">Top Manager - Akses penuh sistem</option>
                    <option value="Manager QC">Manager QC - Manajemen Quality Control</option>
                    <option value="Manager Departemen">Manager Departemen - Manajemen departemen</option>
                    <option value="Admin QC">Admin QC - Admin Quality Control</option>
                    <option value="Admin Departemen - Breadcrumb">Admin Departemen - Breadcrumb</option>
                    <option value="Admin Departemen - Warehouse & Logistik">Admin Departemen - Warehouse & Logistik
                    </option>
                    <option value="Admin Departemen - Further">Admin Departemen - Further</option>
                    <option value="Admin Departemen - Slaughterhouse">Admin Departemen - Slaughterhouse</option>
                    <option value="Admin Departemen - Sausage">Admin Departemen - Sausage</option>
                    <option value="Admin Departemen - Premix">Admin Departemen - Premix</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="userEmail"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <p class="text-xs text-gray-500 mt-1">Opsional - untuk notifikasi sistem</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cabang Akses *</label>
            <div class="border border-gray-300 rounded-lg p-3 max-h-40 overflow-y-auto">
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="userBranchAll" onchange="handleUserBranchSelection('all')"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Semua Cabang</span>
                    </label>
                    <div class="border-t border-gray-200 pt-2">
                        <div class="grid grid-cols-1 gap-2" id="userBranchCheckboxes">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="salatiga" name="userBranches"
                                    onchange="handleUserBranchSelection('salatiga')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Salatiga</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="sragen" name="userBranches"
                                    onchange="handleUserBranchSelection('sragen')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Sragen</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="banyumas" name="userBranches"
                                    onchange="handleUserBranchSelection('banyumas')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Banyumas</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="pemalang" name="userBranches"
                                    onchange="handleUserBranchSelection('pemalang')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Pemalang</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="kebumen" name="userBranches"
                                    onchange="handleUserBranchSelection('kebumen')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Kebumen</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="banjarbaru" name="userBranches"
                                    onchange="handleUserBranchSelection('banjarbaru')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Banjarbaru</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" value="balikpapan" name="userBranches"
                                    onchange="handleUserBranchSelection('balikpapan')"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Balikpapan</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Pilih cabang yang dapat diakses user (dapat lebih dari satu)</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="userStatus" value="active" class="text-blue-600 focus:ring-blue-500"
                        checked>
                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="userStatus" value="inactive" class="text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Tidak Aktif</span>
                </label>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-800 mb-2">Hak Akses Role:</h4>
            <div class="space-y-1 text-xs text-gray-600">
                <div><strong>Top Manager:</strong> Akses penuh ke semua fitur termasuk manajemen user</div>
                <div><strong>Manager QC:</strong> Manajemen Quality Control dan user</div>
                <div><strong>Manager Departemen:</strong> Manajemen departemen dan komplain</div>
                <div><strong>Admin QC:</strong> Admin Quality Control dan input komplain</div>
                <div><strong>Admin Departemen:</strong> Admin departemen spesifik dan input komplain</div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('users.index') }}"
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
function toggleUserPassword() {
    const passwordInput = document.getElementById('userPassword');
    const eyeIcon = document.getElementById('userEyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
    }
}
</script>
@endsection