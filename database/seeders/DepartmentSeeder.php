<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Quality Control',
            'abbrivation' => 'QC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Eksternal',
            'abbrivation' => 'EXT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Produksi Further',
            'abbrivation' => 'FP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Produksi Sausage',
            'abbrivation' => 'SP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Produksi Breadcrumb',
            'abbrivation' => 'BC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Produksi Slaughter House',
            'abbrivation' => 'SH',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Produksi Premix',
            'abbrivation' => 'PRX',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Department::create([
            'uuid' => Str::uuid(),
            'department' => 'Warehouse & Logistik',
            'abbrivation' => 'WH',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
