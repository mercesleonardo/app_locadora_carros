<?php

namespace Database\Seeders;

use App\Models\Locacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Locacao::factory()->count(30)->create();
    }
}
