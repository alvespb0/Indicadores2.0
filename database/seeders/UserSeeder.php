<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'usuario' => 'admin',
            'email' => 'ti@segmetreambiental.com.br',
            'senha' => Hash::make('alterar123'), 
            'setor' => 'admin'
        ]);
    }
}
