<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Saldo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Add kategori
        Kategori::create([
            "namakategori" => "Pemasukan"
        ]); 
        Kategori::create([
            "namakategori" => "Pengeluaran"
        ]); 
        
        Saldo::create([
            "saldo" => 1000000000
        ]); 

    }
}
