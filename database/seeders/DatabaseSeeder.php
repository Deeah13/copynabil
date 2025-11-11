<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Panggil seeder lain secara berurutan
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}