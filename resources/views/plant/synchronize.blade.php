@extends('layouts.layout')

@section('content')
<br>

<!-- Flash Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Sinkronisasi Data Plant Dan Departemen Untuk Plant {{$plant->plant}}</h1>

<!-- Add Access Form -->
<div class="card shadow mb-4">
    <div class="card-body">

        <!-- Add New Access Form -->
        <form action="{{ route('plants.synchronize', $plant->uuid) }}" method="POST">
            @csrf
            <h5>Sinkronisasi Data Plant Dan Departemen Untuk Plant {{$plant->plant}}</h5>
            <div id="access-container">
                <div class="row mb-2 access-row">
                    <div class="col-md-10">
                        <select name="project_uuid[]" class="form-control" required>
                            <option value="">Pilih Project</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->uuid }}">{{ $project->project }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success add-row"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Sinkronisasi</button>
        </form>

    </div>
</div>

@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById("access-container");

    container.addEventListener("click", function(e) {
        if (e.target.classList.contains("add-row") || e.target.closest('.add-row')) {
            const row = e.target.closest('.access-row');
            const clone = row.cloneNode(true);

            // Clear the cloned select values
            clone.querySelectorAll('select').forEach(sel => sel.value = '');

            // Change the add button to remove
            const btn = clone.querySelector('.add-row');
            btn.classList.remove('btn-success', 'add-row');
            btn.classList.add('btn-danger', 'remove-row');
            btn.innerHTML = '<i class="fas fa-minus"></i>';

            container.appendChild(clone);
        }

        if (e.target.classList.contains("remove-row") || e.target.closest('.remove-row')) {
            const row = e.target.closest('.access-row');
            row.remove();
        }
    });
});
</script>
@endsection