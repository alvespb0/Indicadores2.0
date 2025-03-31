<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exame;
use Carbon\Carbon;

class ControllerExame extends Controller
{
    /**
     * Recebe uma request post e faz o cadasstro no banco
     */
    public function cadastrarExames(Request $request){
        try {
            $validatedData = $request->validate([
                'clinicos' => 'required|numeric',
                'audiometrias' => 'required|numeric',
                'laboratoriais' => 'required|numeric',
                'raioX' => 'required|numeric',
                'complementares' => 'required|numeric',
                'competencia' => 'required|date_format:Y-m', // Validando o formato da competência (YYYY-MM)
            ]);
        
            Carbon::setLocale('pt_BR');
            $competenciaFormatted = Carbon::parse($validatedData['competencia'] . '-01') 
            ->translatedFormat('F \\d\\e Y'); #formata como 'fevereiro de 2025'      
        
            $exame = Exame::create([
                'clinicos' => $validatedData['clinicos'],
                'audiometrias' => $validatedData['audiometrias'],
                'laboratoriais' => $validatedData['laboratoriais'],
                'raiox' => $validatedData['raioX'],
                'complementares' => $validatedData['complementares'],
                'competencia' => $competenciaFormatted
            ]);

	    return response()->json([
                'message' => 'Indicador cadastrado com sucesso!',
                'data' => $exame
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
    public function getExames(Request $request){
        $mes = $request->query('mes');
        $ano = $request->query('ano');

        if ($mes && $ano) {
            $competencia = "$mes de $ano";
            $exames = Exame::where('competencia', $competencia)->get();
        } else {
            $exames = Exame::all();
        }
        return view('visualizar-exames', compact('exames'));
    }

    /**
     * recebe um id via método get e exclui o registro com esse id
     * @param int
     * @return redirect
     */
    public function deletarIndicador($id){
        $exames = Exame::find($id);
        $exames->delete();
        return redirect('/visualizar-exames');
    }
}
