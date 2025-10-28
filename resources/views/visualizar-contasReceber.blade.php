<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Contas a Receber</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        td{
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-hand-holding-usd me-2"></i>Sistema de Indicadores - Contas a Receber
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-home me-1"></i>Voltar ao Início
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
                        <h5 class="card-title mb-4">Contas a Receber - Status: Recebido</h5>
                        <div class="col-sm-8">
                            <form name="filterForm" id="filterForm" action="/visualizar-contasReceber" method="GET" class="d-flex justify-content gap-2">
                                <input type="date" name="data_inicial" class="form-control form-control-sm w-auto" placeholder="Data Inicial">
                                <input type="date" name="data_final" class="form-control form-control-sm w-auto" placeholder="Data Final">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt"></i> Filtrar
                                </button>
                            </form>                            
                        </div>

                        @if($contas->count() < 1)
                            <center><h4>Nenhuma conta recebida cadastrada nessa competência</h4></center>
                        @endif

                        <!-- Cards Resumo -->
                        @if($contas->count() > 0)
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-list-ol sector-icon"></i>
                                        <h6 class="card-title">Total de Contas</h6>
                                        <h3 class="mb-0">{{ $contas->count() }}</h3>
                                        <small class="text-muted">Contas Recebidas</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-dollar-sign sector-icon"></i>
                                        <h6 class="card-title">Valor Total</h6>
                                        <h3 class="mb-0">R$ {{ number_format($contas->sum('valor'), 2, ',', '.') }}</h3>
                                        <small class="text-muted">Total Recebido</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calculator sector-icon"></i>
                                        <h6 class="card-title">Valor Médio</h6>
                                        <h3 class="mb-0">R$ {{ number_format($contas->avg('valor'), 2, ',', '.') }}</h3>
                                        <small class="text-muted">Por Conta</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Tabela de Contas -->
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">UUID</th>
                                        <th class="text-center">Descrição</th>
                                        <th class="text-center">Cliente</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Data Vencimento</th>
                                        <th class="text-center">Data Competência</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contas as $conta)
                                        <tr>
                                        <td class="text-center">{{ Str::limit($conta->uuid, 8) }}...</td>
                                        <td class="text-center">{{ $conta->descricao }}</td>
                                        <td class="text-center">{{ $conta->cliente_nome }}</td>
                                        <td class="text-center">R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($conta->data_competencia)->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $conta->status }}</span>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        @if($contas->hasPages())
                        <div class="mt-4">
                            {{ $contas->appends(request()->query())->links('custom-pagination') }}
                        </div>
                        @endif
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
