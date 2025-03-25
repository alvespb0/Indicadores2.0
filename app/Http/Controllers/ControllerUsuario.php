<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class ControllerUsuario extends Controller
{
    public function cadastrarUsuario(Request $request){
        try {
            $validatedData = $request->validate([
                'username' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
                'setor' => 'required|string'
            ]);

            // Criando o exame diretamente com os dados da requisição
            $usuario = Usuario::create([
                'usuario' => $validatedData['username'],
                'email' => $validatedData['email'],
                'senha' => bcrypt($validatedData['password']), // Senha criptografada
                'setor' => $validatedData['setor']            
            ]);
            return response()->json([
                'message' => 'Usuario cadastrado com sucesso!',
                'data' => $usuario
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar Usuario.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
