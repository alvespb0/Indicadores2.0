<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seguranca;
use Carbon\Carbon;

class ControllerSeguranca extends Controller
{
    /**
     * recebe uma request da API através de CSRF e método post, faz a validate data e salva no banco
     * @param Request
     * @return Json|Exception
     */
    public function cadastrarIndicador(Request $request){
        try {
            $validatedData = $request->validate([
                'levantamentosRealizados' => 'required|numeric|min:1', // Mínimo 1
                'treinamentosRealizados' => 'required|numeric|min:1',
                'laudosVendidos' => 'required|numeric|min:1',
                'laudosEmitidos' => 'required|numeric|min:1',
                'competencia' => 'required|date_format:Y-m', // Validando o formato da competência (YYYY-MM)
            ]);
            
            $dataCompetencia = $validatedData['competencia'] . '-01';

            // Criando o exame diretamente com os dados da requisição
            $seguranca = Seguranca::create([
                'levantamentoRealizados' => $validatedData['levantamentosRealizados'],
                'treinamentosRealizados' => $validatedData['treinamentosRealizados'],
                'laudosVendidos' => $validatedData['laudosVendidos'],
                'laudosEmitidos' => $validatedData['laudosEmitidos'],
                'competencia' => $dataCompetencia
            ]);

	    return response()->json([
                'message' => 'Indicador cadastrado com sucesso!',
                'data' => $seguranca
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
    public function getSeguranca(Request $request){
        $mes = $request->query('mes');
        $ano = $request->query('ano');

        if ($mes && $ano) {
            $competencia = "$mes de $ano";
            $indicadores = Seguranca::where('competencia', $competencia)->get();
        } else {
            $indicadores = Seguranca::all();
        }
        return view('visualizar-seguranca', compact('indicadores'));
    }

    /**
     * recebe um id via método get e exclui o registro com esse id
     * @param 
     */
    public function deletarIndicador($id){
        $seguranca = Seguranca::find($id);
        $seguranca->delete();
        return redirect('/visualizar-seguranca');
    }
}
