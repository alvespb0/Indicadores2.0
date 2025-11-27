<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Models\CA_Tokens;
use App\Models\Contas_Receber;
use App\Models\Contas_Pagar;
use App\Models\Projecao_Contas_Pagar;
use App\Models\projecao_contas_receber;
use Carbon\Carbon;

class ContaAzulService
{
    /**
     * Redireciona o usuário para a página de autorização OAuth2 da Conta Azul.
     *
     * Este método monta a URL de autorização da API da Conta Azul utilizando as variáveis de ambiente
     * definidas no `.env` (CLIENT_ID_CA e CONTA_AZUL_REDIRECT_URI). Ele inicia o fluxo OAuth2,
     * redirecionando o usuário para a página de login/autorização da Conta Azul, onde será gerado o
     * código de autorização necessário para obter o access token.
     *
     * Em caso de erro durante o processo, o método registra a exceção no log e redireciona o usuário
     * de volta ao dashboard com uma mensagem de erro.
     *
     * @return \Illuminate\Http\RedirectResponse Redireciona para a URL de autorização da Conta Azul
     *                                           ou para o dashboard em caso de falha.
     *
     * @throws \Exception Caso ocorra algum erro inesperado na construção ou redirecionamento da URL.
     *
     * @example
     * // Exemplo de uso:
     * // Inicia o fluxo OAuth da Conta Azul
     * return $this->getAuthorizationToken();
     *
     * // Isso redirecionará o usuário para:
     * // https://auth.contaazul.com/oauth2/authorize?response_type=code&client_id=XXXX&redirect_uri=XXXX
     */
    public function getAuthorizationToken(){
        $urlRedirect = env('CONTA_AZUL_REDIRECT_URI');
        $client_id = env('CLIENT_ID_CA');
        try{
            $url = "https://auth.contaazul.com/oauth2/authorize?" .
                    "response_type=code" .
                    "&client_id={$client_id}" .
                    "&redirect_uri={$urlRedirect}" .
                    "&scope=openid+profile+aws.cognito.signin.user.admin" .
                    "&state=xyz123";
            return redirect($url);
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao conseguir o token de autorização do CA');
            \Log::error('Erro ao conseguir o Auth Token do Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('dashboard.show');
        }
    }

    /**
     * Obtém o access token e o refresh token da Conta Azul via OAuth2.
     *
     * Este método realiza a requisição HTTP para o endpoint de token da Conta Azul,
     * utilizando o código de autorização previamente obtido no fluxo OAuth2.
     * Ele envia os parâmetros exigidos (client_id, client_secret, grant_type, code e redirect_uri)
     * e autentica a requisição via header "Authorization: Basic base64(client_id:client_secret)".
     *
     * Caso a resposta da API seja bem-sucedida, retorna o corpo JSON contendo os tokens.
     * Em caso de falha, registra os detalhes do erro no log e retorna o status HTTP.
     *
     * Se ocorrer uma exceção durante o processo, o usuário é redirecionado ao dashboard com uma mensagem de erro.
     *
     * @return array|int|\Illuminate\Http\RedirectResponse
     *         - array: Retorna o JSON decodificado com os tokens em caso de sucesso.
     *         - int: Retorna o código de status HTTP em caso de erro na resposta.
     *         - \Illuminate\Http\RedirectResponse: Redireciona para o dashboard em caso de exceção.
     *
     * @throws \Exception Caso ocorra um erro inesperado durante a requisição.
     *
     * @example
     * // Obtém os tokens de acesso da Conta Azul
     * $tokens = $this->getAccessToken();
     *
     * // Exemplo de resposta bem-sucedida:
     * // [
     * //     "access_token" => "eyJraWQiOiJ...",
     * //     "refresh_token" => "eyJjdHkiOiJ...",
     * //     "expires_in" => 3600,
     * //     "token_type" => "Bearer"
     * // ]
     */
    public function getAccessToken(){
        $data = [
            'client_id' => env('CLIENT_ID_CA'),
            'client_secret' => env('SECRET_ID_CA'),
            'grant_type' => 'authorization_code',
            'code' => env('AUTH_TOKEN_CA'),
            'redirect_uri' => env('CONTA_AZUL_REDIRECT_URI')
        ];
        try{
            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode($data['client_id'] . ':' . $data['client_secret']),
                ])
                ->post('https://auth.contaazul.com/oauth2/token', $data);

            if($response->ok()){
                return $response->json();
            } else {
                \Log::error('Erro ao obter access token', ['status' => $response->status(), 'body' => $response->body()]);
                return $response->status();
            }
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao conseguir o token de acesso e refresh do CA');
            \Log::error('Erro ao conseguir o access Token do Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('dashboard.show');
        }
    }

    /**
     * Cria ou atualiza o token de acesso da Conta Azul no banco de dados.
     *
     * Este método garante que sempre exista apenas um registro de token válido na tabela `CA_Tokens`.
     * 
     * Caso não exista nenhum token salvo, ele obtém um novo par de tokens (access e refresh) chamando
     * o método {@see getAccessToken()}, e salva o resultado na tabela.
     *
     * Caso já exista um token salvo, o método realiza o fluxo de **refresh token** para obter um novo
     * access token e atualizar a data de expiração no banco de dados. O refresh token também é
     * atualizado se a API retornar um novo.
     *
     * Todos os erros de comunicação com a API da Conta Azul são registrados no log do sistema.
     *
     * @return void
     *
     * @example
     * // Atualiza o token automaticamente se estiver expirado
     * $this->saveOrRefreshToken();
     *
     * // Após a execução, a tabela `CA_Tokens` conterá sempre o token mais recente.
     */
    public function saveOrRefreshToken(){
        $ca_tokens = CA_Tokens::all();

        if($ca_tokens->isEmpty()){ //verifica se já há algum token cadastrado, só pode haver uma linha no banco
            $data = $this->getAccessToken();
            CA_Tokens::create([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_at' => now()->addSeconds($data['expires_in'])
            ]);
        }else{
            $token = $ca_tokens->first(); //all retorna uma collection

            $data = [
                'client_id' => env('CLIENT_ID_CA'),
                'client_secret' => env('SECRET_ID_CA'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $token->refresh_token
            ];
            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Basic ' . base64_encode($data['client_id'] . ':' . $data['client_secret']),
                ])
                ->post('https://auth.contaazul.com/oauth2/token', $data);

            if($response->ok()){
                $dataNova = $response->json();
                $token->update([
                    'access_token' => $dataNova['access_token'],
                    'refresh_token' => $dataNova['refresh_token'] ?? $token->refresh_token,
                    'expires_at' => now()->addSeconds($dataNova['expires_in'])
                ]);
            }else {
                \Log::error('Erro ao conectar com o conta azul', ['status' => $response->status(), 'body' => $response->body()]);
            }
        }
    }

    public function lancarFinanceiro(){
        $token = CA_Tokens::first();

        if(!$token || $token->expires_at < now()){
            $this->saveOrRefreshToken();
            $token->refresh();
        }

        try{
            \Log::info('Preparando para lançar os números financeiros para data ' . Carbon::yesterday()->toDateString());
            $receber = $this->getContasReceberDia($token->access_token);
            $inadimplentes = $this->getInadimplentesDiario($token->access_token);
            $pagar = $this->getContasPagarDia($token->access_token);
            $pagarAberto = $this->getContasPagarAtrasados($token->access_token);

            \Log::info('Resumo financeiro diário', [
                'receber' => $receber,
                'inadimplentes' => $inadimplentes,
                'pagar' => $pagar,
                'abertos' => $pagarAberto
            ]);
            
            if(!$receber){
                \Log::error('Erro ao lançar os dados de contas a receber do dia '. Carbon::yesterday()->toDateString());
            }

            if(!$inadimplentes){
                \Log::error('Erro ao lançar os dados de inadimplentes do dia '. Carbon::yesterday()->toDateString());
            }

            if(!$pagar){
                \Log::error('Erro ao lançar os dados de contas a pagar do dia '. Carbon::yesterday()->toDateString());
            }

            if(!$pagarAberto){
                \Log::error('Erro ao lançar os dados de contas a pagar do dia '. Carbon::yesterday()->toDateString());
            }

            \Log::info('Finalizado Lançar financeiro');
            
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao lançar os dados financeiros do dia');
            \Log::error('Erro ao lançar os dados financeiros do dia:', [
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    private function getContasReceberDia($access_token){
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $access_token
            ])->get('https://api-v2.contaazul.com/v1/financeiro/eventos-financeiros/contas-a-receber/buscar',[
                'pagina' => 1,
                'tamanho_pagina' => 500, 
                'data_vencimento_de' => Carbon::now()->subMonth()->toDateString(),
                'data_vencimento_ate' => Carbon::yesterday()->toDateString(),
                'status' => 'RECEBIDO'
            ]);
            
            if($response->status() == 200){
                $data = $response->json();
                if(empty($data['itens'])){
                    \Log::info('nenhum registro de contas a receber encontrado para data ' . Carbon::yesterday()->toDateString());
                    return false;
                }else{
                    foreach($data['itens'] as $d){
                        Contas_Receber::updateOrCreate(
                            ['uuid' => $d['id']],
                            [
                                'descricao' => $d['descricao'],
                                'data_vencimento' => $d['data_vencimento'],
                                'status' => $d['status_traduzido'],
                                'valor' => $d['pago'],
                                'cliente_uuid' => $d['cliente']['id'],
                                'cliente_nome' => $d['cliente']['nome'],
                                'data_competencia' => Carbon::yesterday()->toDateString()
                            ]
                        );
                    }
                    return true;
                }
            }else{
                \Log::error('Erro ao buscar contas a receber: ' . $response->body());
                return null;
            }
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao acessar a API para resgatar o CONTAS A RECEBER do CA');
            \Log::error('Erro ao acessar a API para resgatar o CONTAS A RECEBER no Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    private function getInadimplentesDiario($access_token){
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $access_token
            ])->get('https://api-v2.contaazul.com/v1/financeiro/eventos-financeiros/contas-a-receber/buscar',[
                'pagina' => 1,
                'tamanho_pagina' => 500, 
                'data_vencimento_de' => Carbon::now()->subMonths(3)->toDateString(), # TESTE na API vamos voltar daqui 3 meses ou 4 e ver se não está passando do tamanho da pagina 500
                'data_vencimento_ate' => Carbon::yesterday()->toDateString(),
                'status' => 'ATRASADO'
            ]);
            
            if($response->status() == 200){
                $data = $response->json();
                if(empty($data['itens'])){
                    \Log::info('nenhum inadimplente encontrado para a data: ' . Carbon::yesterday()->toDateString());
                    return false;
                }else{
                    Contas_Receber::where('status', 'ATRASADO')->delete();
                    foreach($data['itens'] as $d){
                        Contas_Receber::create([
                            'uuid' => $d['id'],
                            'descricao' => $d['descricao'],
                            'data_vencimento' => $d['data_vencimento'],
                            'status' => $d['status_traduzido'],
                            'valor' => $d['nao_pago'],
                            'cliente_uuid' => $d['cliente']['id'],
                            'cliente_nome' => $d['cliente']['nome'],
                            'data_competencia' => Carbon::yesterday()->toDateString()
                        ]);
                    }
                    return true;
                }
            }else{
                \Log::error('Erro ao buscar os inadimplentes: ' . $response->body());
                return null;
            }
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao acessar a API para resgatar o CONTAS A RECEBER com filtro de inadimplentes do CA');
            \Log::error('Erro ao acessar a API para resgatar o CONTAS A RECEBER com filtro de inadimplentes no Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    private function getContasPagarDia($access_token){
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $access_token
            ])->get('https://api-v2.contaazul.com/v1/financeiro/eventos-financeiros/contas-a-pagar/buscar',[
                'pagina' => 1,
                'tamanho_pagina' => 500, 
                'data_vencimento_de' => Carbon::now()->subMonth()->toDateString(),
                'data_vencimento_ate' => Carbon::yesterday()->toDateString(),
                'status' => 'RECEBIDO'
            ]);
            
            if($response->status() == 200){
                $data = $response->json();
                if(empty($data['itens'])){
                    \Log::info('nenhum registro de contas a pagar encontrado para data ' . Carbon::yesterday()->toDateString());
                    return false;
                }else{
                    foreach($data['itens'] as $d){
                        Contas_Pagar::updateOrCreate(
                            ['uuid' => $d['id']],
                            [
                                'descricao' => $d['descricao'],
                                'data_vencimento' => $d['data_vencimento'],
                                'status' => $d['status_traduzido'],
                                'valor' => $d['pago'],
                                'fornecedor_uuid' => $d['fornecedor']['id'],
                                'fornecedor_nome' => $d['fornecedor']['nome'],
                                'data_competencia' => Carbon::yesterday()->toDateString()
                            ]
                        );
                    }
                    return true;
                }
            }else{
                \Log::error('Erro ao buscar contas a pagar: ' . $response->body());
                return null;
            }
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao acessar a API para resgatar o CONTAS A PAGAR do CA');
            \Log::error('Erro ao acessar a API para resgatar o CONTAS A PAGAR no Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }    

    private function getContasPagarAtrasados($access_token){
        try{
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $access_token
            ])->get('https://api-v2.contaazul.com/v1/financeiro/eventos-financeiros/contas-a-pagar/buscar',[
                'pagina' => 1,
                'tamanho_pagina' => 500, 
                'data_vencimento_de' => Carbon::now()->subMonths(3)->toDateString(), # TESTE na API vamos voltar daqui 3 meses ou 4 e ver se não está passando do tamanho da pagina 500
                'data_vencimento_ate' => Carbon::yesterday()->toDateString(),
                'status' => 'ATRASADO'
            ]);
            
            if($response->status() == 200){
                $data = $response->json();
                if(empty($data['itens'])){
                    \Log::info('nenhum conta em aberto encontrado para a data: ' . Carbon::yesterday()->toDateString());
                    return false;
                }else{
                    Contas_Pagar::where('status', 'ATRASADO')->delete();
                    foreach($data['itens'] as $d){
                        Contas_Pagar::create([
                            'uuid' => $d['id'],
                            'descricao' => $d['descricao'],
                            'data_vencimento' => $d['data_vencimento'],
                            'status' => $d['status_traduzido'],
                            'valor' => $d['nao_pago'],
                            'fornecedor_uuid' => $d['fornecedor']['id'],
                            'fornecedor_nome' => $d['fornecedor']['nome'],
                            'data_competencia' => Carbon::yesterday()->toDateString()
                        ]);
                    }
                    return true;
                }
            }else{
                \Log::error('Erro ao buscar contas em aberto: ' . $response->body());
                return null;
            }
        }catch(\Exception $e){
            session()->flash('error', 'Erro ao acessar a API para resgatar o contas a pagar com filtro de atrasados do CA');
            \Log::error('Erro ao acessar a API para resgatar o CONTAS A PAGAR com filtro de atrasados no Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    public function getProjecaoContasPagar($access_token){
        try{
            $pagina = 1;
            $data = [];

            do{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '. $access_token
                ])->get('https://api-v2.contaazul.com/v1/financeiro/eventos-financeiros/contas-a-pagar/buscar',[
                    'pagina' => $pagina,
                    'tamanho_pagina' => 100, 
                    'data_vencimento_de' => Carbon::now()->toDateString(),
                    'data_vencimento_ate' => Carbon::now()->addDays(365)->toDateString(),
                ]);

                if($response->failed()){
                    // rate-limit (429) 10 por segundo
                    if ($response->status() == 429) {
                        sleep(2);
                        continue;
                    }
                    \Log::error('Erro ao acessar a API para resgatar a PROJEÇÃO CONTAS A PAGAR no Conta Azul:', [
                        'error' => $response->body(),
                    ]);
                    return null;
                }

                $data = $response->json();

                if(empty($data['itens'])){
                    break; # não precisa logar, ele vai retornar null quando o loop acabar de qualquer forma
                }

                foreach($data['itens'] as $d){
                    Projecao_Contas_Pagar::updateOrCreate(
                        ['uuid' => $d['id']],
                        [
                            'descricao' => $d['descricao'],
                            'data_vencimento' => $d['data_vencimento'],
                            'status' => $d['status_traduzido'],
                            'valor' => $d['total'],
                            'fornecedor_uuid' => $d['fornecedor']['id'],
                            'fornecedor_nome' => $d['fornecedor']['nome'],
                            'data_competencia' => $d['data_vencimento']
                        ]
                    );
                }
                $pagina++;
                
                usleep(150 * 1000); // delay para rate limit
            }while(!empty($data['itens']));
            
            return true;

        }catch(\Exception $e){
            \Log::error('Erro ao acessar a API para resgatar a PROJEÇÃO CONTAS A PAGAR no Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    public function getProjecaoContasReceber($access_token){
        try{
            $pagina = 1;
            $data = [];

            do{
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '. $access_token
                ])->get('https://api-v2.contaazul.com/v1/financeiro/eventos-financeiros/contas-a-receber/buscar',[
                    'pagina' => $pagina,
                    'tamanho_pagina' => 100, 
                    'data_vencimento_de' => Carbon::now()->toDateString(),
                    'data_vencimento_ate' => Carbon::now()->addDays(365)->toDateString(),
                ]);
                if($response->failed()){
                    // rate-limit (429) 10 por segundo
                    if ($response->status() == 429) {
                        sleep(2);
                        continue;
                    }
                    \Log::error('Erro ao acessar a API para resgatar a PROJEÇÃO CONTAS A RECEBER no Conta Azul:', [
                        'error' => $response->body(),
                    ]);
                    return null;
                }

                $data = $response->json();

                if(empty($data['itens'])){
                    break; # não precisa logar, ele vai retornar null quando o loop acabar de qualquer forma
                }

                foreach($data['itens'] as $d){
                    Projecao_Contas_Receber::updateOrCreate(
                        ['uuid' => $d['id']],
                        [
                            'descricao' => $d['descricao'],
                            'data_vencimento' => $d['data_vencimento'],
                            'status' => $d['status_traduzido'],
                            'valor' => $d['total'],
                            'cliente_uuid' => $d['cliente']['id'],
                            'cliente_nome' => $d['cliente']['nome'],
                            'data_competencia' => Carbon::yesterday()->toDateString()
                        ]
                    );
                }
                $pagina++;
                
                usleep(150 * 1000); // delay para rate limit
            }while(!empty($data['itens']));
            
            return true;

        }catch(\Exception $e){
            \Log::error('Erro ao acessar a API para resgatar a PROJEÇÃO CONTAS A RECEBER no Conta Azul:', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }

    }
}

?>