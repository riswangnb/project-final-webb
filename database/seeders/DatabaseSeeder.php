<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan AdminSeeder terlebih dahulu
        $this->call([
            AdminSeeder::class,
        ]);

        // Data dummy (uncomment jika diperlukan untuk development/testing)
        // $this->seedDummyData();
    }

    /**
     * Seed dummy data for development/testing
     */
    private function seedDummyData(): void
    {
        // Buat 10 user dummy menggunakan factory
        User::factory(10)->create();

        // Buat user 'Test User' jika belum ada
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Ganti jika perlu
            ]
        );

        // Jalankan seeder tambahan
        $this->call([
            DummyOrdersSeeder::class,
            // Tambahkan seeder lainnya di sini jika perlu
        ]);
    }
}
