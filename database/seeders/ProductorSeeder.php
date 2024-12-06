<?php

namespace Database\Seeders;

use App\Models\Productor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Productor::factory()->count(500)->create();
    }
}
