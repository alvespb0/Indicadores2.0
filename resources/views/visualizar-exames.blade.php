
<?php
$totalExames = [];
if(count($exames) > 1){
    $totalExames = [
        'clinicos' => 0,
        'audiometrias' => 0,
        'laboratoriais' => 0,
        'raiox' => 0,
        'complementares' => 0
    ];

    foreach ($exames as $totalExame) {
        $totalExames['clinicos'] += $totalExame->clinicos;
        $totalExames['audiometrias'] += $totalExame->audiometrias;
        $totalExames['laboratoriais'] += $totalExame->laboratoriais;
        $totalExames['raiox'] += $totalExame->raiox;
        $totalExames['complementares'] += $totalExame->complementares;
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
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-stethoscope me-2"></i>Sistema de Indicadores - Exames
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro-exames.html">
                            <i class="fas fa-plus-circle me-1"></i>Cadastrar Indicadores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">
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
                        <form name = "filterForm" id="filterForm" action="/visualizar-exames" method="GET" class="d-flex justify-content">
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

                        <?php if(count($totalExames) > 0){?>
                        <div class="row g-4">
                            <!-- Card Exames Clínicos -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-md sector-icon"></i>
                                        <h6 class="card-title">Exames Clínicos</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['clinicos'];?></h3>
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
                                        <h3 class="mb-0"><?php echo $totalExames['audiometrias'];?></h3>
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
                                        <h3 class="mb-0"><?php echo $totalExames['laboratoriais'];?></h3>
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
                                        <h3 class="mb-0"><?php echo $totalExames['raiox'];?></h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Exames Complementares -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Complementares</h6>
                                        <h3 class="mb-0"><?php echo $totalExames['complementares']; ?></h3>
                                        <small class="text-muted">Total do Mês</small>
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
                                        <h3 class="mb-0"><?php echo $e->raiox;?>0</h3>
                                        <small class="text-muted">Total do Mês</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Exames Complementares -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-plus-circle sector-icon"></i>
                                        <h6 class="card-title">Exames Complementares</h6>
                                        <h3 class="mb-0"><?php echo $e->complementares;?></h3>
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
                                        <th>Competência</th>
                                        <th>Exames Clínicos</th>
                                        <th>Audiometrias</th>
                                        <th>Exames Laboratoriais</th>
                                        <th>Raio X</th>
                                        <th>Exames Complementares</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($exames as $exame): ?>
                                        <tr>
                                        <td><?php echo $exame->competencia; ?></td>
                                        <td><?php echo $exame->clinicos; ?></td>
                                        <td><?php echo $exame->audiometrias; ?></td>
                                        <td><?php echo $exame->laboratoriais; ?></td>
                                        <td><?php echo $exame->raiox ; ?></td>
                                        <td><?php echo $exame->complementares; ?></td>
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