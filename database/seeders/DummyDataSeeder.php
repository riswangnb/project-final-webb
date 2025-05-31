<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    /**
     * Seed dummy data for development and testing.
     */
    public function run(): void
    {
        // Buat 10 user dummy menggunakan factory
        User::factory(10)->create();

        // Buat user 'Test User' jika belum ada
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Jalankan seeder tambahan untuk data dummy
        $this->call([
            DummyOrdersSeeder::class,
            ServicesSeeder::class,
            CustomerSeeder::class,
        ]);

        $this->command->info('Dummy data seeded successfully!');
    }
}
