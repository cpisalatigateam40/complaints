<!-- Navigation -->
<nav class="bg-white shadow-lg border-b border-gray-100">
    <div class="max-w-7xl mx-auto">
        <!-- Top Header -->
        <div class="flex justify-between items-center py-4 border-b border-gray-100">
            <!-- Logo & Title -->
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center"
                        id="notificationBadgeContainer" style="display: none;">
                        <span class="text-white text-xs font-bold" id="notificationBadge">0</span>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Sistem Rekap Komplain</h1>
                    <p class="text-xs text-gray-500">Manajemen Keluhan Pelanggan</p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Branch Filter Button -->
                <button onclick="openBranchModal()" id="branchFilterBtn"
                    class="flex items-center space-x-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg px-3 py-2 text-sm font-medium text-blue-700 hover:from-blue-100 hover:to-indigo-100 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <span id="branchFilterText">Semua Cabang</span>
                </button>

                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-800" id="userFullName">{{Auth::user()->name}}</p>
                        <p class="text-xs text-gray-500" id="userRole">{{Auth::user()->role->role ?? '-'}}</p>
                    </div>
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <button onclick="logout()"
                        class="text-gray-500 hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50"
                        title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="py-3">
            <div class="flex space-x-1">
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200
    {{ request()->is('dashboard*') ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('complaints.index') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200
    {{ request()->is('complaints*') ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span>Data Komplain</span>
                </a>

                <a href="{{ route('users.index') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200
    {{ request()->is('users*') ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <span>Manajemen User</span>
                </a>

                <a href="{{ route('plants.index') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200
    {{ request()->is('plants*') ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <span>Plant</span>
                </a>

                <a href="{{ route('departments.index') }}"
                    class="flex items-center space-x-2 px-4 py-2 rounded-lg font-medium transition-all duration-200
    {{ request()->is('departments*') ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                    <span>Department</span>
                </a>



            </div>
        </div>
    </div>
</nav>

<!-- Branch Filter Modal -->
<div id="branchModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-2xl p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Filter Cabang</h3>
                    <p class="text-blue-100 text-sm mt-1">Pilih cabang untuk menampilkan data</p>
                </div>
                <button onclick="closeBranchModal()" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <!-- Select All Option -->
            <label
                class="flex items-center space-x-3 p-3 hover:bg-blue-50 rounded-xl cursor-pointer transition-colors duration-200 border-2 border-transparent hover:border-blue-100">
                <input type="checkbox" id="branchAll" onchange="handleBranchSelection('all')"
                    class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-2" checked>
                <div class="flex items-center space-x-3">
                    <div class="w-4 h-4 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full shadow-sm"></div>
                    <span class="font-medium text-gray-800">Semua Cabang</span>
                </div>
            </label>

            <div class="border-t border-gray-200 my-4"></div>

            <!-- Individual Branches -->
            <div class="space-y-2" id="branchCheckboxes">
                <!-- Branch checkboxes will be populated by JavaScript -->
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 mt-6 pt-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-600" id="selectedBranchCount">7 cabang dipilih</span>
                    <div class="flex space-x-2">
                        <button onclick="resetBranchFilter()"
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                            Reset
                        </button>
                        <button onclick="applyBranchFilter()"
                            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
let complaints = [];
let editingIndex = -1;
let currentUser = null;
let editingUserIndex = -1;
let selectedBranches = ['all']; // Default: semua cabang

const branches = [{
        id: 'salatiga',
        name: 'Salatiga'
    },
    {
        id: 'sragen',
        name: 'Sragen'
    },
    {
        id: 'banyumas',
        name: 'Banyumas'
    },
    {
        id: 'pemalang',
        name: 'Pemalang'
    },
    {
        id: 'kebumen',
        name: 'Kebumen'
    },
    {
        id: 'banjarbaru',
        name: 'Banjarbaru'
    },
    {
        id: 'balikpapan',
        name: 'Balikpapan'
    }
];

function openBranchModal() {
    const modal = document.getElementById('branchModal');
    modal.classList.remove('hidden');
    // Add animation
    setTimeout(() => {
        modal.querySelector('.bg-white').classList.remove('scale-95');
        modal.querySelector('.bg-white').classList.add('scale-100');
    }, 10);
}

function closeBranchModal() {
    const modal = document.getElementById('branchModal');
    modal.querySelector('.bg-white').classList.remove('scale-100');
    modal.querySelector('.bg-white').classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}

function resetBranchFilter() {
    selectedBranches = ['all'];
    document.getElementById('branchAll').checked = true;
    branches.forEach(branch => {
        document.getElementById(`branch_${branch.id}`).checked = false;
    });
    updateSelectedBranchCount();
}

function handleBranchSelection(branchId) {
    if (branchId === 'all') {
        const allCheckbox = document.getElementById('branchAll');
        const individualCheckboxes = branches.map(b => document.getElementById(`branch_${b.id}`));

        if (allCheckbox.checked) {
            // Select all
            selectedBranches = ['all'];
            individualCheckboxes.forEach(cb => cb.checked = false);
        } else {
            // Deselect all
            selectedBranches = [];
        }
    } else {
        const branchCheckbox = document.getElementById(`branch_${branchId}`);
        const allCheckbox = document.getElementById('branchAll');

        if (branchCheckbox.checked) {
            // Add branch to selection
            if (selectedBranches.includes('all')) {
                selectedBranches = [branchId];
                allCheckbox.checked = false;
            } else {
                selectedBranches.push(branchId);
            }
        } else {
            // Remove branch from selection
            selectedBranches = selectedBranches.filter(id => id !== branchId);
            allCheckbox.checked = false;
        }

        // If all individual branches are selected, check "all"
        const allIndividualSelected = branches.every(b =>
            document.getElementById(`branch_${b.id}`).checked
        );

        if (allIndividualSelected) {
            selectedBranches = ['all'];
            allCheckbox.checked = true;
            branches.forEach(b => {
                document.getElementById(`branch_${b.id}`).checked = false;
            });
        }
    }

    updateSelectedBranchCount();
}

function updateSelectedBranchCount() {
    const countElement = document.getElementById('selectedBranchCount');
    if (selectedBranches.includes('all')) {
        countElement.textContent = '7 cabang dipilih';
    } else {
        countElement.textContent = `${selectedBranches.length} cabang dipilih`;
    }
}

function applyBranchFilter() {
    // Ensure at least one branch is selected
    if (selectedBranches.length === 0) {
        selectedBranches = ['all'];
        document.getElementById('branchAll').checked = true;
    }

    updateBranchFilterText();
    closeBranchModal();

    // Refresh current page data
    const currentPage = getCurrentPage();
    if (currentPage === 'dashboard') {
        updateDashboard();
    } else if (currentPage === 'complaints') {
        updateComplaintsTable();
    } else if (currentPage === 'users') {
        updateUsersTable();
        updateUserStats();
    }
}

function updateBranchFilterText() {
    const textElement = document.getElementById('branchFilterText');
    if (selectedBranches.includes('all')) {
        textElement.textContent = 'Semua Cabang';
    } else if (selectedBranches.length === 1) {
        const branchName = branches.find(b => b.id === selectedBranches[0])?.name;
        textElement.textContent = branchName || 'Pilih Cabang';
    } else if (selectedBranches.length <= 3) {
        const branchNames = selectedBranches.map(id =>
            branches.find(b => b.id === id)?.name
        ).join(', ');
        textElement.textContent = branchNames;
    } else {
        textElement.textContent = `${selectedBranches.length} Cabang Dipilih`;
    }
}

function logout() {
    // Create custom confirmation modal
    const confirmModal = document.createElement('div');
    confirmModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    confirmModal.innerHTML = `
<div class="bg-white rounded-lg p-6 max-w-md mx-4">
<h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h3>
<p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
<div class="flex justify-end space-x-4">
<button onclick="this.closest('.fixed').remove()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                            Batal
</button>

                <a class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" href="{{route('logout')}}">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
</button>
</div>
</div>
            `;
    document.body.appendChild(confirmModal);
}

function confirmLogout() {
    currentUser = null;
    localStorage.removeItem('currentUser');
    showLoginPage();
    // Reset form
    document.getElementById('loginForm').reset();
    document.getElementById('loginError').classList.add('hidden');
}
</script>
@endsection