<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function logarUsuario(Request $request){
        $validatedData = $request->validate([
            'sector' => 'required|string',
            'email' => 'required|string',
            'senha' => 'required|string'
            ]);
            
        $user = Usuario::where('email', $request->email)->first();
        if (!$user || !password_verify($request->senha, $user->senha)) {
            return response()->json(['error' => 'Usuário ou senha inválidos'], 401);
        }

        if ($user->setor !== $request->sector) {
            return response()->json(['error' => 'Setor incorreto'], 403);
        }    
        // Criando a sessão do usuário
        Session::put('usuario', $user->usuario);  // Pegando 'usuario' do banco
        Session::put('setor', $request->sector); // Pegando setor da request
    
        return response()->json([
            'message' => 'Login realizado com sucesso',
            'usuario' => $user->usuario,
            'setor' => $user->setor
            ],200);
    }
}
