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
                'levantamentosRealizados' => 'required|numeric',
                'treinamentosRealizados' => 'required|numeric',
                'laudosVendidos' => 'required|numeric',
                'laudosEmitidos' => 'required|numeric',
                'competencia' => 'required|date_format:Y-m', // Validando o formato da competência (YYYY-MM)
            ]);
        
            Carbon::setLocale('pt_BR');
            $competenciaFormatted = Carbon::createFromFormat('Y-m', $request->competencia)
            ->translatedFormat('F \\d\\e Y'); // Exemplo: "Janeiro de 2025"

            // Criando o exame diretamente com os dados da requisição
            $seguranca = Seguranca::create([
                'levantamentoRealizados' => $request->levantamentosRealizados,
                'treinamentosRealizados' => $request->treinamentosRealizados,
                'laudosVendidos' => $request->laudosVendidos,
                'laudosEmitidos' => $request->laudosEmitidos,
                'competencia' => $competenciaFormatted
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
}
