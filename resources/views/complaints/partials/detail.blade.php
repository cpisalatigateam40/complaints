<div class="grid md:grid-cols-2 gap-10">
    <div class="space-y-4">
        <h4 class="text-lg font-semibold mb-2 border-b pb-1">Informasi Dasar</h4>
        <p><strong>No:</strong> {{ $complaint->id }}</p>
        <p><strong>Tanggal:</strong> {{ $complaint->date->format('d/m/Y') }}</p>
        <p><strong>Nama Produk:</strong> {{ $complaint->product_name ?? '-' }}</p>
        <p><strong>Kode Produksi:</strong> {{ $complaint->production_code }}</p>
        <p><strong>Best Before:</strong> {{ $complaint->best_before->format('d/m/Y') }}</p>
        <p><strong>Jumlah Dikomplain:</strong> {{ $complaint->complaint_amount }}</p>
        <p>
            <strong>Status:</strong>
            @if ($complaint->status == 0)
            <span class="bg-red-100 text-red-700 px-2 py-1 text-sm rounded-full">Open</span>
            @else
            <span class="bg-green-100 text-green-700 px-2 py-1 text-sm rounded-full">Close</span>
            @endif
        </p>
    </div>

    <div class="space-y-4">
        <h4 class="text-lg font-semibold mb-2 border-b pb-1">Informasi Pelanggan</h4>
        <p><strong>Pelanggan:</strong> {{ $complaint->customer }}</p>
        <p><strong>Tanggal Kedatangan:</strong> {{ $complaint->product_arrival_date->format('d/m/Y') }}</p>
        <p><strong>Penyampaian:</strong> {{ $complaint->delivery }}</p>
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
</div>