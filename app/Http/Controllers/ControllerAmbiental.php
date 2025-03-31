<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambiental;
use Carbon\Carbon;

class ControllerAmbiental extends Controller
{
    /**
     * recebe uma request da API através de CSRF e método post, faz a validate data e salva no banco
     * @param Request
     * @return Json|Exception
     */
    public function cadastrarIndicador(Request $request){
        try {
            $validatedData = $request->validate([
                'orcamentosRealizados' => 'required|numeric',
                'orcamentosAprovados' => 'required|numeric',
                'clientesNovos' => 'required|numeric',
                'competencia' => 'required|date_format:Y-m', // Validando o formato da competência (YYYY-MM)
            ]);
        
            Carbon::setLocale('pt_BR');
            $competenciaFormatted = Carbon::parse($validatedData['competencia'] . '-01')  
            ->translatedFormat('F \\d\\e Y'); #formata como 'fevereiro de 2025'      
            
            // Criando o exame diretamente com os dados da requisição
            $ambiental = Ambiental::create([
                'orcamentosRealizados' => $validatedData['orcamentosRealizados'],
                'orcamentosAprovados' => $validatedData['orcamentosAprovados'],
                'clientesNovos' => $validatedData['clientesNovos'],
                'competencia' => $competenciaFormatted
            ]);
            return response()->json([
                'message' => 'Indicador cadastrado com sucesso!',
                'data' => $ambiental
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar indicador.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Recebe uma request Get (pelo filtro de data ou vazio se estiver sem filtro)
     * e retorna os indicadores correspondentes a data (ou todos eles)
     * @param request 
     * @return Array
     */
    public function getAmbiental(Request $request){
        $mes = $request->query('mes');
        $ano = $request->query('ano');

        if ($mes && $ano) {
            $competencia = "$mes de $ano";
            $indicadores = Ambiental::where('competencia', $competencia)->get();
        } else {
            $indicadores = Ambiental::all();
        }
        return view('visualizar-ambiental', compact('indicadores'));
    }

    /**
     * recebe um id via método get e exclui o registro com esse id
     * @param 
     */
    public function deletarIndicador($id){
        $ambiental = Ambiental::find($id);
        $ambiental->delete();
        return redirect('/visualizar-ambiental');
    }
}
