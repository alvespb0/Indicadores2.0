<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Indicadores - Comercial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-chart-line me-2"></i>Sistema de Indicadores - Comercial
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/comercial">
                            <i class="fas fa-plus-circle me-1"></i>Cadastrar Indicadores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="fas fa-sign-out-alt me-1"></i>Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Indicadores do Setor Comercial</h5>
                        <div class="col-sm-6">
                            <form name="filterForm" id="filterForm" action="/visualizar-comercial" method="GET" class="d-flex justify-content">
                                <input type="month" name="competencia" class="form-control form-control-sm w-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt"></i> Filtrar
                                </button>
                            </form>                            
                        </div>

                        @if($indicadores->count() < 1)
                            <center><h4>Nenhum indicador cadastrado nessa competência</h4></center>
                        @endif

                        @if(count($totalComercial) > 1)
                        <div class="row g-4">
                            <!-- Card Propostas Enviadas -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-paper-plane sector-icon"></i>
                                        <h6 class="card-title">Propostas Enviadas</h6>
                                        <h3 class="mb-0">{{ $totalComercial['propostasEnviadas'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Propostas Fechadas -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-circle sector-icon"></i>
                                        <h6 class="card-title">Propostas Fechadas</h6>
                                        <h3 class="mb-0">{{ $totalComercial['propostasFechadas'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Clientes Novos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-plus sector-icon"></i>
                                        <h6 class="card-title">Clientes Novos</h6>
                                        <h3 class="mb-0">{{ $totalComercial['clientesNovos'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Renovações -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-sync sector-icon"></i>
                                        <h6 class="card-title">Renovações</h6>
                                        <h3 class="mb-0">{{ $totalComercial['renovacoes'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Valor Total -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-dollar-sign sector-icon"></i>
                                        <h6 class="card-title">Valor Total</h6>
                                        <h3 class="mb-0">{{ $totalComercial['valorTotal'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            @foreach($indicadores as $i)
                            <div class="row g-4">
                            <!-- Card Propostas Enviadas -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-paper-plane sector-icon"></i>
                                        <h6 class="card-title">Propostas Enviadas</h6>
                                        <h3 class="mb-0">{{ $i->propostasEnviadas }}</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Propostas Fechadas -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-circle sector-icon"></i>
                                        <h6 class="card-title">Propostas Fechadas</h6>
                                        <h3 class="mb-0">{{ $i->propostasFechadas }}</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Clientes Novos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-plus sector-icon"></i>
                                        <h6 class="card-title">Clientes Novos</h6>
                                        <h3 class="mb-0">{{ $i->clientesNovos }}</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Renovações -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-sync sector-icon"></i>
                                        <h6 class="card-title">Renovações</h6>
                                        <h3 class="mb-0">{{ $i->renovacoes }}</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Valor Total -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-dollar-sign sector-icon"></i>
                                        <h6 class="card-title">Valor Total</h6>
                                        <h3 class="mb-0">{{ $i->valorTotal }}</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <!-- Tabela de Histórico -->
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Competência</th>
                                        <th class="text-center">Propostas Enviadas</th>
                                        <th class="text-center">Propostas Fechadas</th>
                                        <th class="text-center">Clientes Novos</th>
                                        <th class="text-center">Renovações</th>
                                        <th class="text-center">Valor Total</th>
                                        @if(Session::get('setor') == 'admin')
                                        <th class="text-center">Ação</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($indicadores as $i)
                                    <tr>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($i->competencia)->translatedFormat('F \d\e Y') }}</td>
                                    <td class="text-center">{{ $i->propostasEnviadas }}</td>
                                    <td class="text-center">{{ $i->propostasFechadas }}</td>
                                    <td class="text-center">{{ $i->clientesNovos }}</td>
                                    <td class="text-center">{{ $i->renovacoes }}</td>
                                    <td class="text-center">{{ $i->valorTotal }}</td>
                                    @if(Session::get('setor') == 'admin')
                                    <td class="text-center"><a href="{{ route('comercial.deletar', ['id'=>$i->id]) }}" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esse indicador?')">deletar</a></td>
                                    @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p class="footer-text">© 2024 Sistema de Indicadores - Saúde Ocupacional</p>
                <div class="footer-links">
                    <a href="#"><i class="fas fa-info-circle me-1"></i>Sobre</a>
                    <a href="#"><i class="fas fa-envelope me-1"></i>Contato</a>
                    <a href="#"><i class="fas fa-shield-alt me-1"></i>Política de Privacidade</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
