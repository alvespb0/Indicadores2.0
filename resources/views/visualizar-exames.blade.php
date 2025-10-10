
<?php
$setor = Session::get('setor');
$usuario = Session::get('usuario');
if($setor !== 'exames' && $setor !== 'admin'){
    header("Location: http://{$_SERVER['HTTP_HOST']}/login");
    exit;
}
$totalExames = [];
if(count($exames) > 1){
    $totalExames = [
        'clinicos' => 0,
        'audiometrias' => 0,
        'laboratoriais' => 0,
        'raiox' => 0,
        'eeg' => 0,
        'ecg' => 0,
        'espirometria' => 0,
        'acuidade' => 0,
        'outros_exames' => 0
    ];

    foreach ($exames as $totalExame) {
        $totalExames['clinicos'] += $totalExame->clinicos;
        $totalExames['audiometrias'] += $totalExame->audiometrias;
        $totalExames['laboratoriais'] += $totalExame->laboratoriais;
        $totalExames['raiox'] += $totalExame->raiox;
        $totalExames['eeg'] += $totalExame->eeg;
        $totalExames['ecg'] += $totalExame->ecg;
        $totalExames['acuidade'] += $totalExame->acuidade;
        $totalExames['espirometria'] += $totalExame->espirometria;
        $totalExames['outros_exames'] += $totalExame->outros_exames;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Indicadores - Exames</title>
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
                <i class="fas fa-stethoscope me-2"></i>Sistema de Indicadores - Exames
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/exames">
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
                        <h5 class="card-title mb-4">Indicadores do Setor de Exames</h5>
                        <div class="col-sm-6">
                            <form name = "filterForm" id="filterForm" action="/visualizar-exames" method="GET" class="d-flex justify-content">
                                <input type="month" name="competencia" class="form-control form-control-sm w-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calendar-alt"></i> Filtrar
                                </button>
                            </form>                            
                        </div>
                        <?php if(count($exames) < 1){
                                echo "<center><h4> Nenhum indicador cadastrado nessa competência </h4></center>";
                            }
                        ?>
                        <?php if(count($totalExames) > 0){?>
                        <div class="row g-4">
                            <!-- Card Exames Clínicos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-md sector-icon"></i>
                                        <h6 class="card-title">Exames Clínicos</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['clinicos'];?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Audiometrias -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                    <i class="fas fa-deaf sector-icon"></i>
                                    <h6 class="card-title">Audiometrias</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['audiometrias'];?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Exames Laboratoriais -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-flask sector-icon"></i>
                                        <h6 class="card-title">Exames Laboratoriais</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['laboratoriais'];?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Raio X -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-x-ray sector-icon"></i>
                                        <h6 class="card-title">Raio X</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['raiox'];?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Exames Complementares -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">EEG</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['eeg']; ?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">ECG</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['ecg']; ?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Espirometria</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['espirometria']; ?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Acuidade Visual</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['acuidade']; ?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Outros Exames</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['outros_exames']; ?></h3>
                                        <small class="text-muted">Total do Período</small>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- _______________________________________________________________________________________ -->

                        
                        <?php }else{ foreach ($exames as $e): ?>
                            <div class="row g-4">
                            <!-- Card Exames Clínicos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-md sector-icon"></i>
                                        <h6 class="card-title">Exames Clínicos</h6>
                                        <h3 class="mb-0"><?php echo $e->clinicos;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Audiometrias -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                    <i class="fas fa-deaf sector-icon"></i>
                                    <h6 class="card-title">Audiometrias</h6>
                                        <h3 class="mb-0"><?php echo $e->audiometrias;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Exames Laboratoriais -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-flask sector-icon"></i>
                                        <h6 class="card-title">Exames Laboratoriais</h6>
                                        <h3 class="mb-0"><?php echo $e->laboratoriais;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Raio X -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-x-ray sector-icon"></i>
                                        <h6 class="card-title">Raio X</h6>
                                        <h3 class="mb-0"><?php echo $e->raiox;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Exames Complementares -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">ECG</h6>
                                        <h3 class="mb-0"><?php echo $e->ecg;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>
          
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">EEG</h6>
                                        <h3 class="mb-0"><?php echo $e->eeg;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Espirometria</h6>
                                        <h3 class="mb-0"><?php echo $e->espirometria;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Acuidade Visual</h6>
                                        <h3 class="mb-0"><?php echo $e->acuidade;?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Outros Exames</h6>
                                        <h3 class="mb-0"><?php echo $e->outros_exames; ?></h3>
                                        <small class="text-muted">Total do Mês</small>
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
                                        <th class="text-center">Exames Clínicos</th>
                                        <th class="text-center">Audiometrias</th>
                                        <th class="text-center">Exames Laboratoriais</th>
                                        <th class="text-center">Raio X</th>
                                        <th class="text-center">ECG</th>
                                        <th class="text-center">EEG</th>
                                        <th class="text-center">Espiro</th>
                                        <th class="text-center">Acuidade</th>
                                        <th class="text-center">Outros Exames</th>
                                        @if($setor == 'admin')
                                        <th class="text-center">Ação</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($exames as $exame): ?>
                                        <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($exame->competencia)->translatedFormat('F \d\e Y') }}</td>
                                        <td class="text-center"><?php echo $exame->clinicos; ?></td>
                                        <td class="text-center"><?php echo $exame->audiometrias; ?></td>
                                        <td class="text-center"><?php echo $exame->laboratoriais; ?></td>
                                        <td class="text-center"><?php echo $exame->raiox ; ?></td>
                                        <td class="text-center"><?php echo $exame->ecg; ?></td>
                                        <td class="text-center"><?php echo $exame->eeg; ?></td>
                                        <td class="text-center"><?php echo $exame->espirometria; ?></td>
                                        <td class="text-center"><?php echo $exame->acuidade; ?></td>
                                        <td class="text-center">{{$exame->outros_exames}}</td>

                                        @if($setor == 'admin')
                                        <td class="text-center"><a href="{{ route('exame.deletar', ['id'=>$exame->id]) }}" class = "btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esse indicador?')">deletar</a></td>
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