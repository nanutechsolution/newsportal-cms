<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Pemilik Media',
            'Pimpinan Redaksi',
            'Redaktur',
            'Editor',
            'Wartawan',
            'Kontributor',
            'Moderator',
            'Customer Service',
            'Guest'
        ];

        // Super Admin biasanya sudah dibuat otomatis oleh Filament Shield install command
        
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $this->command->info('Enterprise Roles berhasil di-generate!');
    }
}