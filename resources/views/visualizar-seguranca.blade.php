<?php
$setor = Session::get('setor');
$usuario = Session::get('usuario');
if($setor !== 'seguranca' && $setor !== 'admin'){
    header("Location: http://{$_SERVER['HTTP_HOST']}/login");
    exit;
}
$totalSeguranca = [];
if(count($indicadores) > 1){
    $totalSeguranca = [
        'levantamentosRealizados' => 0,
        'treinamentosRealizados' => 0,
        'laudosVendidos' => 0,
        'laudosEmitidos' => 0,
    ];

    foreach ($indicadores as $totalIndicadores) {
        $totalSeguranca['levantamentosRealizados'] += (int) $totalIndicadores['levantamentoRealizados'];
        $totalSeguranca['treinamentosRealizados'] += (int) $totalIndicadores['treinamentosRealizados'];
        $totalSeguranca['laudosVendidos'] += (int) $totalIndicadores['laudosVendidos'];
        $totalSeguranca['laudosEmitidos'] += (int) $totalIndicadores['laudosEmitidos'];
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Indicadores - Segurança do Trabalho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-hard-hat me-2"></i>Sistema de Indicadores - Segurança do Trabalho
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/seguranca">
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
                        <h5 class="card-title mb-4">Indicadores do Setor de Segurança do Trabalho</h5>
                        <form name = "filterForm" id="filterForm" action="/visualizar-seguranca" method="GET" class="d-flex justify-content">
                            <div class="input-group" style="width: 420px;">
                                <select class="form-select" name="mes" id="mes">
                                    <option value="">Selecione o Mês</option>
                                    <option value="Janeiro">Janeiro</option>
                                    <option value="Fevereiro">Fevereiro</option>
                                    <option value="Março">Março</option>
                                    <option value="Abril">Abril</option>
                                    <option value="Maio">Maio</option>
                                    <option value="Junho">Junho</option>
                                    <option value="Julho">Julho</option>
                                    <option value="Agosto">Agosto</option>
                                    <option value="Setembro">Setembro</option>
                                    <option value="Outubro">Outubro</option>
                                    <option value="Novembro">Novembro</option>
                                    <option value="Dezembro">Dezembro</option>
                                </select>

                                <select class="form-select" name="ano" id="ano">
                                    <option value="">Selecione o Ano</option>
                                    <?php 
                                        $anoAtual = date('Y'); 
                                        for ($i = $anoAtual; $i >= $anoAtual - 10; $i--) { 
                                            echo "<option value='$i'>$i</option>"; 
                                        }
                                    ?>
                                </select>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt"></i> Filtrar
                                </button>
                            </div>
                        </form>
                        <br>
                        <?php if(count($indicadores) < 1){
                                echo "<center><h4> Nenhum indicador cadastrado nessa competência </h4></center>";
                            }
                            if(count($totalSeguranca) > 1){
                        ?>
                        <div class="row g-4">
                            <!-- Card Levantamentos Realizados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clipboard-check sector-icon"></i>
                                        <h6 class="card-title">Levantamentos Realizados</h6>
                                        <h3 class="mb-0"><?php echo $totalSeguranca['levantamentosRealizados']; ?></h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Treinamentos Realizados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chalkboard-teacher sector-icon"></i>
                                        <h6 class="card-title">Treinamentos Realizados</h6>
                                        <h3 class="mb-0"><?php echo $totalSeguranca['treinamentosRealizados']; ?></h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Laudos Vendidos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-invoice sector-icon"></i>
                                        <h6 class="card-title">Laudos Vendidos</h6>
                                        <h3 class="mb-0"><?php echo $totalSeguranca['laudosVendidos']; ?> </h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Laudos Emitidos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-signature sector-icon"></i>
                                        <h6 class="card-title">Laudos Emitidos</h6>
                                        <h3 class="mb-0"><?php echo $totalSeguranca['laudosEmitidos']; ?></h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }else{
                                foreach($indicadores as $i): ?>
                        <div class="row g-4">
                            <!-- Card Levantamentos Realizados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clipboard-check sector-icon"></i>
                                        <h6 class="card-title">Levantamentos Realizados</h6>
                                        <h3 class="mb-0"><?php echo $i->levantamentoRealizados; ?></h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Treinamentos Realizados -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chalkboard-teacher sector-icon"></i>
                                        <h6 class="card-title">Treinamentos Realizados</h6>
                                        <h3 class="mb-0"><?php echo $i->treinamentosRealizados; ?></h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Laudos Vendidos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-invoice sector-icon"></i>
                                        <h6 class="card-title">Laudos Vendidos</h6>
                                        <h3 class="mb-0"><?php echo $i->laudosVendidos; ?> </h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Laudos Emitidos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-signature sector-icon"></i>
                                        <h6 class="card-title">Laudos Emitidos</h6>
                                        <h3 class="mb-0"><?php echo $i->laudosEmitidos ?></h3>
                                        <small class="text-muted">Total do período</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endforeach;} ?>
                        <!-- Tabela de Histórico -->
                        <div class="table-responsive mt-4">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Competência</th>
                                        <th class="text-center">Levantamentos Realizados</th>
                                        <th class="text-center">Treinamentos Realizados</th>
                                        <th class="text-center">Laudos Vendidos</th>
                                        <th class="text-center">Laudos Emitidos</th>
                                        @if($setor == 'admin')
                                        <th class="text-center">Ação</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($indicadores as $i):?>
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item->competencia)->translatedFormat('F \d\e Y') }}</td>
                                        <td class="text-center"><?php echo $i->levantamentoRealizados ?></td>
                                        <td class="text-center"><?php echo $i->treinamentosRealizados ?></td>
                                        <td class="text-center"><?php echo $i->laudosVendidos ?></td>
                                        <td class="text-center"><?php echo $i->laudosEmitidos ?></td>
                                        @if($setor == 'admin')
                                        <td class="text-center"><a href="{{ route('seguranca.deletar', ['id'=>$i->id]) }}" class = "btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esse indicador?')">deletar</a></td>
                                        @endif
                                    </tr>
                                    <?php endforeach; ?>
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