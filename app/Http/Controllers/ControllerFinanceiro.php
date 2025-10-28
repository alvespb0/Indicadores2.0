<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contas_Pagar;
use App\Models\Contas_Receber;
use Illuminate\Support\Facades\Session;

class ControllerFinanceiro extends Controller
{
    /**
     * Retorna contas a receber com status "Recebido"
     */
    public function getContasReceber(Request $request){
        // Verificação de autorização
        $setor = Session::get('setor');
        if($setor !== 'financeiro' && $setor !== 'admin'){
            return redirect('/login');
        }

        $query = Contas_Receber::where('status', 'RECEBIDO');

        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('data_competencia', [$request->data_inicial, $request->data_final]);
        }

        $contas = $query->orderBy('data_competencia', 'desc')->paginate(15);
        
        return view('visualizar-contasReceber', compact('contas'));
    }

    /**
     * Retorna contas a receber com status "Atrasado" (inadimplentes)
     */
    public function getInadimplentes(Request $request){
        // Verificação de autorização
        $setor = Session::get('setor');
        if($setor !== 'financeiro' && $setor !== 'admin'){
            return redirect('/login');
        }

        $query = Contas_Receber::where('status', 'ATRASADO');

        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('data_competencia', [$request->data_inicial, $request->data_final]);
        }

        $contas = $query->orderBy('data_competencia', 'desc')->paginate(15);
        
        return view('visualizar-inadimplentes', compact('contas'));
    }

    /**
     * Retorna todas as contas a pagar
     */
    public function getContasPagar(Request $request){
        // Verificação de autorização
        $setor = Session::get('setor');
        if($setor !== 'financeiro' && $setor !== 'admin'){
            return redirect('/login');
        }

        $query = Contas_Pagar::query();

        if ($request->filled('data_inicial') && $request->filled('data_final')) {
            $query->whereBetween('data_competencia', [$request->data_inicial, $request->data_final]);
        }

        $contas = $query->orderBy('data_competencia', 'desc')->paginate(15);
        
        return view('visualizar-contasPagar', compact('contas'));
    }
}
