<div class="grid md:grid-cols-2 gap-10">
    <div class="space-y-4">
        <h4 class="text-lg font-semibold mb-2 border-b pb-1">Informasi Dasar</h4>
        <p><strong>No:</strong> {{ $complaint->id }}</p>
        <p><strong>Tanggal:</strong> {{ $complaint->date->format('d/m/Y') }}</p>
        <p><strong>Nama Produk:</strong> {{ $complaint->product_name ?? '-' }}</p>
        <p><strong>Kode Produksi:</strong> {{ $complaint->production_code ?? '-'}}</p>
        <p><strong>Best Before:</strong>
            {{ $complaint->best_before ? $complaint->best_before->format('d/m/Y') : '-' }}
        </p>
        <p><strong>Jumlah Dikomplain:</strong> {{ $complaint->complaint_amount }} {{ $complaint->unit }}</p>
        <p>
            <strong>Status:</strong>
            @if ($complaint->status == '0')
            <span class="px-2 py-1 rounded-full text-sm bg-red-100 text-red-700">
                Open
            </span>
            @elseif ($complaint->status == '1')
            <span class="px-2 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700">
                Sedang Diinvestigasi
            </span>
            @elseif ($complaint->status == '2')
            <span class="px-2 py-1 rounded-full text-sm bg-green-100 text-green-700">
                Selesai
            </span>
            @elseif ($complaint->status == '3')
            <span class="px-2 py-1 rounded-full text-sm bg-red-100 text-red-700">
                Rejected
            </span>
            @else
            <span class="px-2 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                Tidak Diketahui
            </span>
            @endif
        </p>
    </div>

    <div class="space-y-4">
        <h4 class="text-lg font-semibold mb-2 border-b pb-1">Informasi Pelanggan</h4>
        <p><strong>Pelanggan:</strong> {{ $complaint->customer }}</p>
        <p><strong>Tanggal Kedatangan:</strong>
            {{ $complaint->product_arrival_date ? $complaint->product_arrival_date->format('d/m/Y') : '-'}}
        </p>
        @php
        $deliveryLabels = [
        1 => 'Email',
        2 => 'Telepon',
        3 => 'WhatsApp',
        4 => 'Langsung',
        ];
        @endphp

        <p><strong>Penyampaian:</strong> {{ $deliveryLabels[$complaint->delivery] ?? '-' }}</p>
        <p><strong>NCR:</strong> {{ $complaint->ncr ?? '-' }}</p>
    </div>
</div>

<hr class="my-4">

<div class="space-y-4">
    <div class="space-y-4">
        <strong>Jenis Ketidaksesuaian</strong>
        <p>{{ $complaint->nonconformity_type }}</p>
        <hr>
    </div>

    <div class="space-y-4">
        <strong>Lokasi Akar Masalah</strong><br>
        @forelse ($complaint->root_causes as $r)
        <span class="inline-block bg-blue-100 text-blue-700 text-sm px-2 py-1 rounded-full mr-1 mt-1">
            {{ $r->root_cause_name }}
        </span>
        @empty
        -
        @endforelse
    </div>

    {{-- 🖼️ New Documentation Section --}}
    <div class="space-y-4">
        <strong>Dokumentasi Komplain</strong><br>
        @if ($complaint->documentations->isNotEmpty())
        <div class="flex flex-wrap gap-3 mt-2">
            @foreach ($complaint->documentations as $doc)
            <a href="{{ asset('storage/' . $doc->path) }}" target="_blank">
                <img src="{{ asset('storage/' . $doc->path) }}" alt="Dokumentasi Komplain"
                    class="w-32 h-32 object-cover rounded border hover:scale-105 transition-transform">
            </a>
            @endforeach
        </div>
        @else
        <p>-</p>
        @endif
    </div>

    <div class="space-y-4">
        <strong>Faktor Penyebab</strong>
        <p>{{$complaint->corrective_action->causative_factor ?? '-'}}</p>
    </div>

    <hr class="my-4">

    <div class="space-y-4">
        <strong>Tindakan Perbaikan Jangka Pendek</strong>
        <p>{{$complaint->corrective_action->short_term_ca ?? '-'}}</p>
    </div>

    <div class="space-y-4">
        <strong>Tindakan Perbaikan Jangka Panjang</strong>
        <p>{{$complaint->corrective_action->long_term_ca ?? '-'}}</p>
    </div>

    @if($complaint->status == 1)
    <div class="mt-6 flex gap-3">

        {{-- Tombol Terima --}}
        <a href="{{ route('complaints.approved', $complaint->uuid) }}"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition">
            ✔ Terima
        </a>

        {{-- Tombol Tolak --}}
        <button
            type="button"
            onclick="openRejectModal('{{ $complaint->uuid }}')"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition">
            ✖ Tolak
        </button>
    </div>
    @endif
    @if($complaint->status == 3)
    <div class="space-y-4">
        <strong>Alasan Ditolak</strong>
        <p>{{$complaint->notes}}</p>
    </div>
    @endif
</div>