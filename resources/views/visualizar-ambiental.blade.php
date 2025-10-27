<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Indicadores - Ambiental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-leaf me-2"></i>Sistema de Indicadores - Ambiental
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/ambiental">
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
                        <h5 class="card-title mb-4">Indicadores do Setor Ambiental</h5>
                        <div class="col-sm-6">
                            <form name="filterForm" id="filterForm" action="/visualizar-ambiental" method="GET" class="d-flex justify-content">
                                    <input type="month" name="competencia" class="form-control form-control-sm w-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-calendar-alt"></i> Filtrar
                                    </button>
                            </form>                            
                        </div>
                        
                        @if($indicadores->count() < 1)
                            <center><h4>Nenhum indicador cadastrado nessa competência</h4></center>
                        @endif

                        @if(count($totalAmbiental) > 1)
                        <div class="row g-4">
                            <!-- Card Orçamentos Realizados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-invoice-dollar sector-icon"></i>
                                        <h6 class="card-title">Orçamentos Realizados</h6>
                                        <h3 class="mb-0">{{ $totalAmbiental['orcamentosRealizados'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Orçamentos Aprovados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-double sector-icon"></i>
                                        <h6 class="card-title">Orçamentos Aprovados</h6>
                                        <h3 class="mb-0">{{ $totalAmbiental['orcamentosAprovados'] }}</h3>
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
                                        <h3 class="mb-0">{{ $totalAmbiental['clientesNovos'] }}</h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            @foreach($indicadores as $i)
                        <div class="row g-4">
                            <!-- Card Orçamentos Realizados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-invoice-dollar sector-icon"></i>
                                        <h6 class="card-title">Orçamentos Realizados</h6>
                                        <h3 class="mb-0">{{ $i->orcamentosRealizados }}</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Orçamentos Aprovados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-double sector-icon"></i>
                                        <h6 class="card-title">Orçamentos Aprovados</h6>
                                        <h3 class="mb-0">{{ $i->orcamentosAprovados }}</h3>
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
                        </div>
                        @endforeach
                        @endif

                        <!-- Tabela de Histórico -->
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Competência</th>
                                        <th class="text-center">Orçamentos Realizados</th>
                                        <th class="text-center">Orçamentos Aprovados</th>
                                        <th class="text-center">Clientes Novos</th>
                                        @if(Session::get('setor') == 'admin')
                                        <th class="text-center">Ação</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($indicadores as $i)
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($i->competencia)->translatedFormat('F \d\e Y') }}</td>
                                        <td class="text-center">{{ $i->orcamentosRealizados }}</td>
                                        <td class="text-center">{{ $i->orcamentosAprovados }}</td>
                                        <td class="text-center">{{ $i->clientesNovos }}</td>
                                        @if(Session::get('setor') == 'admin')
                                        <td class="text-center"><a href="{{ route('ambiental.deletar', ['id'=>$i->id]) }}" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esse indicador?')">deletar</a></td>
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
