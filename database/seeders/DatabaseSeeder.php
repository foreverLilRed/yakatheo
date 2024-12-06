<?php

namespace Database\Seeders;

use App\Models\Seal;
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
        User::create([
            'name' => 'Pedro Alberto Rojas Maldonado',
            'email'=> 'projasma2002@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        Seal::insert([
            ['name' => 'Orgánico Estados Unidos', 'description' => 'Certificación orgánica en EE.UU.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Unión Europea', 'description' => 'Certificación orgánica en Europa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comercio Justo', 'description' => 'Certificación de comercio justo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rainforest Alliance', 'description' => 'Certificación de sostenibilidad', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cero Deforestación', 'description' => 'Certificación de conservación ambiental', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agricultura Familiar', 'description' => 'Apoyo a la agricultura familiar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Conservación Ambiental', 'description' => 'Prácticas sostenibles para el medio ambiente', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->call(ProductorSeeder::class);
    }
}
