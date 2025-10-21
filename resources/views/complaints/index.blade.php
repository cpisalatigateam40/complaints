@extends('layouts.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Add Complaint Button -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Data Komplain</h2>
            <p class="text-gray-600 mt-1">Kelola semua data komplain pelanggan</p>
        </div>
        <a href="{{ route('complaints.create') }}"
            class="group bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <div
                class="w-6 h-6 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
            </div>
            <span class="font-semibold">Tambah Komplain</span>
        </a>
    </div>

    <!-- Complaints Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">No</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Tanggal</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Produk</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Pelanggan</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Cabang</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Status</th>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($complaints as $index => $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-4">{{ $index + 1 }}</td>
                        <td class="px-4 py-4">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-4">
                            {{ $item->product_name ?? '-' }}
                        </td>
                        <td class="px-4 py-4">{{ $item->customer }}</td>
                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                {{ $item->plant->plant ?? 'undefined' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            @if($item->status == '0')
                            <span class="px-2 py-1 rounded-full text-sm bg-red-100 text-red-700">Open</span>
                            @else
                            <span class="px-2 py-1 rounded-full text-sm bg-green-100 text-green-700">Close</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 space-x-2">
                            <a href="#" class="text-blue-600 hover:underline"
                                onclick="openDetailModal('{{ $item->uuid }}')">
                                Lihat
                            </a>
                            <a href="{{ route('complaints.edit', $item->uuid) }}"
                                class="text-green-600 hover:underline">Edit</a>
                            <form action="{{ route('complaints.destroy', $item->uuid) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')"
                                    class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Belum ada data komplain.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Complaint Modal -->
<div id="complaintModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Tambah Komplain Baru</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
            </div>
        </div>


    </div>
</div>
<!-- View Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-800">Detail Komplain</h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
        </div>
        <div id="detailContent" class="p-6">
            <!-- Detail content akan dimuat lewat fetch -->
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
function openDetailModal(uuid) {
    const modal = document.getElementById('detailModal');
    const content = document.getElementById('detailContent');

    modal.classList.remove('hidden');
    content.innerHTML = `<div class="text-center py-10 text-gray-500">Memuat data...</div>`;

    fetch(`/complaints/${uuid}`)
        .then(res => res.text())
        .then(html => content.innerHTML = html)
        .catch(err => {
            console.error(err);
            content.innerHTML = `<div class="text-center text-red-500 py-10">Gagal memuat data.</div>`;
        });
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>


@endsection