<?php

namespace Database\Seeders;

use App\Models\DepartmentPlant;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = DepartmentPlant::first();

        $user1 = User::create([
            'uuid' => Str::uuid(),
            'username' => 'superadmin',
            'name' => 'superadmin',
            'email' => 'superadmin@cp.co.id',
            'email_verified_at' => now(),
            'password' => bcrypt('cpi12345'),
            'department_uuid' => $department->uuid
        ]);
    }
}