@extends('layouts.layout')

@section('content')
<div>
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h4 class="text-2xl font-semibold text-gray-800 mb-4">Manage Departemen</h4>

        <!-- Info Alerts -->
        <div class="space-y-2 mb-6">
            <div class="bg-blue-100 text-blue-800 text-sm p-3 rounded-md border border-blue-300">
                <b>*Jika sudah terdapat departemen yang terdaftar, silahkan gunakan departemen tersebut.</b>
            </div>
            <div class="bg-yellow-100 text-yellow-800 text-sm p-3 rounded-md border border-yellow-300">
                <b>*Untuk QC silahkan gunakan departemen QC, untuk nama departemen produksi, dapat disesuaikan.</b>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('plants.update-manage-department', $plant->uuid) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Checkbox Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($departments as $department)
                <label for="department_{{ $department->uuid }}"
                    class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-gray-50 transition">
                    <input type="checkbox" name="department[]" value="{{ $department->uuid }}"
                        id="department_{{ $department->uuid }}"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ $plant->realDepartments->pluck('uuid')->contains($department->uuid) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700 text-sm">{{ $department->department }}</span>
                </label>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-8">
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('plants.index') }}"
                    class="px-5 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection