<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Comercial;

class ControllerComercial extends Controller
{
    public function cadastrarIndicador(Request $request){
        try {
            $validatedData = $request->validate([
                'propostasEnviadas' => 'required|numeric',
                'propostasFechadas' => 'required|numeric',
                'clientesNovos' => 'required|numeric',
                'renovacoes' => 'required|numeric',
                'valorTotal' => 'required|numeric',
                'competencia' => 'required|date_format:Y-m', // Validando o formato da competência (YYYY-MM)
            ]);

            $dataCompetencia = $validatedData['competencia'] . '-01';

            $indicador = Comercial::create([
                'propostasEnviadas' => $validatedData['propostasEnviadas'],
                'propostasFechadas' => $validatedData['propostasFechadas'],
                'clientesNovos' => $validatedData['clientesNovos'],
                'renovacoes' => $validatedData['renovacoes'],
                'valorTotal' => $validatedData['valorTotal'],
                'competencia' => $dataCompetencia,
            ]);
            return response()->json([
                'message' => 'Indicador cadastrado com sucesso!',
                'data' => $indicador
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar indicador.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifica se essa request existe, se essa request existe, o front está encaminhando um filtro de data 
     * se não, retorna todos os exames
     */
    public function getComercial(Request $request){
        $query = Comercial::query();

        if ($request->filled('competencia')) {
            [$ano, $mes] = explode('-', $request->competencia);
            $query->whereYear('competencia', $ano)
                ->whereMonth('competencia', $mes);
        }

        $indicadores = $query->orderBy('competencia', 'desc')->get();
        return view('visualizar-comercial', compact('indicadores'));
    }

    /**
     * recebe um id via método get e exclui o registro com esse id
     * @param 
     */
    public function deletarIndicador($id){
        $comercial = Comercial::find($id);
        $comercial->delete();
        return redirect('/visualizar-comercial');
    }
}
