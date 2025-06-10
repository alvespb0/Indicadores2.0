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
            'email' => 'arthur@segmetre.com.br',
            'senha' => Hash::make('teamomae6@'), // Hash da senha
            'setor' => 'admin'
        ]);
    }
}
