<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder {
    public function run(): void {
        // Aktor di sistem termasuk Publik, Admin, Guru, dan Orang Tua 
        Role::create(['nama_role' => 'Admin']);
        Role::create(['nama_role' => 'Guru']);
        Role::create(['nama_role' => 'Orang Tua']);
    }
}