<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Leonardo Carvalho',
            'email' => 'leonardokarvalho@gmail.com',
            'password' => Hash::make(env('DEFAULT_USER_PASSWORD'))
        ]);

        $this->call([
            LocacaoSeeder::class
        ]);
    }
}
