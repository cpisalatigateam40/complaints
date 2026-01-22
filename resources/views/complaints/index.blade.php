@extends('layouts.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- HEADER + BUTTON -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Data Komplain</h2>
            <p class="text-gray-600 mt-1">Kelola semua data komplain pelanggan</p>
        </div>

        @can('can add data')
        <a href="{{ route('complaints.create') }}"
            class="group bg-gradient-to-r from-green-600 to-emerald-600 text-white px-8 py-4 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <div
                class="w-6 h-6 bg-white bg-opacity-20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <span class="font-semibold">Tambah Komplain</span>
        </a>
        @endcan
    </div>

    <!-- FILTER SECTION -->
    <div class="bg-white p-4 rounded-xl shadow mb-6">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end" id="filterForm">

            <!-- Month -->
            <div>
                <label class="block text-gray-700 font-medium">Bulan</label>
                <select name="month" class="border rounded-lg px-3 py-2 w-full"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua</option>
                    @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-gray-700 font-medium">Tahun</label>
                <select name="year" class="border rounded-lg px-3 py-2 w-full"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua</option>
                    @foreach(range(2023, now()->year) as $y)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 font-medium">Status</label>
                <select name="status" class="border rounded-lg px-3 py-2 w-full"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua</option>
                    <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Open</option>
                    <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Investigasi</option>
                    <option value="3" {{ request('status')==='3' ? 'selected' : '' }}>Reject</option>
                    <option value="2" {{ request('status')==='2' ? 'selected' : '' }}>Close</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-gray-700 font-medium">Sortir</label>
                <select name="sort" class="border rounded-lg px-3 py-2 w-full"
                    onchange="document.getElementById('filterForm').submit()">
                    <option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>Tanggal Input</option>
                    <option value="date" {{ request('sort')=='date'?'selected':'' }}>Tanggal Komplain</option>
                    <option value="customer" {{ request('sort')=='customer'?'selected':'' }}>Pelanggan</option>
                    <option value="product_name" {{ request('sort')=='product_name'?'selected':'' }}>Produk</option>
                </select>
            </div>

            <div class="md:col-span-5 flex justify-end">
                <a href="{{ route('complaints.index', ['reset' => 1]) }}"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Reset Filter
                </a>
            </div>
        </form>

        <!-- TOTAL COMPLAINT -->
        <div class="mt-4">
            <h3 class="text-lg font-semibold text-gray-800">
                Total Komplain:
                <span class="text-blue-600">{{ $total_complaints }}</span>
            </h3>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-4 px-6 font-medium text-gray-600">No</th>

                        <th class="text-left py-4 px-6 font-medium text-gray-600">
                            <a href="?sort=date&direction={{ request('direction')=='asc'?'desc':'asc' }}"
                                class="hover:underline">Tanggal</a>
                        </th>

                        @role('Superadmin')
                        <th class="text-left py-4 px-6 font-medium text-gray-600">

                            <form method="GET" id="filterDeptForm">
                                <select name="departmentplant"
                                    onchange="document.getElementById('filterDeptForm').submit()"
                                    class="border rounded px-2 py-1 text-sm">

                                    <option value="">-- Semua Departemen --</option>

                                    @foreach ($departmentPlants as $dp)
                                    <option value="{{ $dp->department->department }}"
                                        {{ $filterDept == $dp->department->department ? 'selected' : '' }}>
                                        {{ $dp->department->department }}
                                    </option>
                                    @endforeach
                                </select>

                                {{-- Keep pagination & sort params --}}
                                <input type="hidden" name="month" value="{{ request('month') }}">
                                <input type="hidden" name="year" value="{{ request('year') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="hidden" name="direction" value="{{ request('direction') }}">
                            </form>

                        </th>
                        @endrole

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

                        <td class="px-4 py-4">{{ \Carbon\Carbon::parse($item->date)->format('d-M-Y') }}</td>

                        @role('Superadmin')
                        <td class="px-4 py-4">
                            @forelse ($item->root_causes as $r)
                            <span class="inline-block bg-blue-100 text-blue-700 text-sm px-2 py-1 rounded-full mr-1">
                                {{ $r->root_cause_name }}
                            </span>
                            @empty
                            -
                            @endforelse
                        </td>
                        @endrole

                        <td class="px-4 py-4">{{ $item->product_name ?? '-' }}</td>

                        <td class="px-4 py-4">{{ $item->customer }}</td>

                        <td class="px-4 py-4">
                            <span class="px-2 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                {{ $item->plant->plant ?? 'undefined' }}
                            </span>
                        </td>

                        <td class="px-4 py-4">
                            @if ($item->status == '0')
                            <span class="px-2 py-1 rounded-full text-sm bg-red-100 text-red-700">Open</span>
                            @elseif ($item->status == '1')
                            <span class="px-2 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">Sedang Diinvestigasi</span>
                            @elseif ($item->status == '2')
                            <span class="px-2 py-1 rounded-full text-sm bg-green-100 text-green-700">Selesai</span>
                            @elseif ($item->status == '3')
                            <span class="px-2 py-1 rounded-full text-sm bg-green-100 text-red-700">Reject</span>
                            @else
                            <span class="px-2 py-1 rounded-full text-sm bg-gray-100 text-gray-700">Tidak Diketahui</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 space-x-2">

                            @can('can update data')
                            <a href="{{route('complaints.update-data', $item->uuid)}}" class="text-black-600 hover:underline">Update</a>
                            @endcan

                            <a href="#" class="text-blue-600 hover:underline"
                                onclick="openDetailModal('{{ $item->uuid }}')">Lihat</a>

                            @can('can edit data')
                            <a href="{{ route('complaints.edit', $item->uuid) }}" class="text-green-600 hover:underline">Edit</a>
                            @endcan

                            @can('can delete data')
                            <form action="{{ route('complaints.destroy', $item->uuid) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                    class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                            @endcan

                            @can('can update status')
                            <select onchange="updateStatus('{{ $item->uuid }}', this.value)"
                                class="ml-2 border rounded px-2 py-1 text-sm">
                                <option value="0" @selected($item->status == 0)>Open</option>
                                <option value="1" @selected($item->status == 1)>Investigasi</option>
                                <option value="2" @selected($item->status == 2)>Close</option>
                            </select>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-3 text-center text-gray-500">Belum ada data komplain.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $complaints->links() }}
        </div>
    </div>

</div>

<!-- DETAIL MODAL -->
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-full overflow-y-auto">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-gray-800">Detail Komplain</h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 text-2xl">×</button>
        </div>
        <div id="detailContent" class="p-6">
            <!-- Loaded dynamically -->
        </div>
    </div>
</div>

<div id="rejectModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4">Alasan Penolakan</h2>

        <form method="POST" id="rejectForm">
            @csrf

            <textarea name="reject_note"
                class="w-full border rounded-lg p-3 focus:ring focus:ring-red-300"
                rows="4"
                placeholder="Masukkan alasan penolakan..."
                required></textarea>

            <div class="flex justify-end mt-4 gap-2">
                <button type="button"
                    onclick="closeRejectModal()"
                    class="px-4 py-2 bg-gray-300 rounded-lg">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    const routes = {
        show: "{{ route('complaints.show-complaints', ':uuid') }}",
        reject: "{{ route('complaints.reject', ':uuid') }}",
        updateStatus: "{{ route('complaints.updateStatus', ':uuid') }}"
    };
</script>
<script>
    function openRejectModal(uuid) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');

        form.action = routes.reject.replace(':uuid', uuid);

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openDetailModal(uuid) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailContent');

        modal.classList.remove('hidden');
        content.innerHTML = `<div class="text-center py-10 text-gray-500">Memuat data...</div>`;

        fetch(routes.show.replace(':uuid', uuid))
            .then(res => res.text())
            .then(html => content.innerHTML = html)
            .catch(() => {
                content.innerHTML =
                    `<div class="text-center text-red-500 py-10">Gagal memuat data.</div>`;
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    function updateStatus(uuid, newStatus) {
        if (!confirm('Yakin ingin mengubah status komplain ini?')) return;

        fetch(routes.updateStatus.replace(':uuid', uuid), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Status berhasil diperbarui');
                    location.reload();
                } else {
                    alert('Gagal memperbarui status');
                }
            })
            .catch(() => alert('Terjadi kesalahan koneksi'));
    }
</script>
@endpush