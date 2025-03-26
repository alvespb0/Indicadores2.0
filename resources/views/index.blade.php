<?php
$usuario = Session::get('usuario');
$setor = Session::get('setor');
echo $setor;
if(empty($usuario) || empty($setor)){
    header("Location: http://{$_SERVER['HTTP_HOST']}/login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Indicadores - Saúde Ocupacional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .body{
            overflow: hidden;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-chart-line me-2"></i>Sistema de Indicadores
            </a>
            <ul class="navbar-nav ms-auto">
                <?php if($setor == 'admin'){?>
                    <li class="nav-item">
                        <a class="nav-link" href="/usuario">
                            <i class="fa-solid fa-circle-user"></i> &nbsp Cadastrar Usuarios
                        </a>
                    </li>
                <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="fas fa-sign-out-alt me-1"></i> &nbsp Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="display-4 mb-1">Bem-vindo ao Sistema de Indicadores</h1>
                    <p class="lead">Selecione o setor para acessar ou visualizar os indicadores</p>
                    <div class="collapse navbar-collapse" id="navbarNav">
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Card Exames -->
                <?php if($setor == 'admin' || $setor == 'exames'):?> 
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-stethoscope sector-icon"></i>
                            <h5 class="card-title">Exames</h5>
                            <p class="card-text">Gestão de indicadores relacionados a exames</p>
                            <div class="d-grid gap-2">
                                <a href="exames" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Acessar
                                </a>
                                <a href="/visualizar-exames" class="btn btn-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Visualizar Indicadores
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>

                <!-- Card Comercial -->
                <?php if($setor == 'admin' || $setor == 'comercial'):?> 
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line sector-icon"></i>
                            <h5 class="card-title">Comercial</h5>
                            <p class="card-text">Gestão de indicadores do setor comercial</p>
                            <div class="d-grid gap-2">
                                <a href="/comercial" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Acessar
                                </a>
                                <a href="/visualizar-comercial" class="btn btn-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Visualizar Indicadores
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Card Segurança do Trabalho -->
                <?php if($setor == 'admin' || $setor == 'seguranca'):?> 
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-hard-hat sector-icon"></i>
                            <h5 class="card-title">Segurança do Trabalho</h5>
                            <p class="card-text">Gestão de indicadores de segurança ocupacional</p>
                            <div class="d-grid gap-2">
                                <a href="/seguranca" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Acessar
                                </a>
                                <a href="/visualizar-seguranca" class="btn btn-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Visualizar Indicadores
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Card Ambiental -->
                <?php if($setor == 'admin' || $setor == 'ambiental'):?> 
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-leaf sector-icon"></i>
                            <h5 class="card-title">Ambiental</h5>
                            <p class="card-text">Gestão de indicadores do setor ambiental</p>
                            <div class="d-grid gap-2">
                                <a href="/ambiental" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Acessar
                                </a>
                                <a href="/visualizar-ambiental" class="btn btn-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Visualizar Indicadores
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?> 
            </div>
        </div>
    </main>

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