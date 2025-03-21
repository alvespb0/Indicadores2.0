<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Indicadores - Ambiental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-leaf me-2"></i>Sistema de Indicadores
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">
                            <i class="fas fa-sign-out-alt me-1"></i>Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sector-header">
        <div class="container">
            <h1 class="sector-title">Setor Ambiental</h1>
            <p class="sector-subtitle">Cadastro de Indicadores</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form id="ambientalForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="orcamentosRealizados" class="form-label">
                                        <i class="fas fa-file-invoice-dollar me-2"></i>Orçamentos Realizados
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calculator"></i>
                                        </span>
                                        <input type="number" class="form-control" id="orcamentosRealizados" name="orcamentosRealizados" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="orcamentosAprovados" class="form-label">
                                        <i class="fas fa-check-double me-2"></i>Orçamentos Aprovados
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-file-signature"></i>
                                        </span>
                                        <input type="number" class="form-control" id="orcamentosAprovados" name="orcamentosAprovados" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="clientesNovos" class="form-label">
                                        <i class="fas fa-user-plus me-2"></i>Clientes Novos
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <input type="number" class="form-control" id="clientesNovos" name="clientesNovos" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="competencia" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Competência
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <input type="month" class="form-control" id="competencia" name="competencia" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Salvar Indicadores
                                </button>
                                <a href="visualizar-ambiental.html" class="btn btn-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Visualizar Indicadores
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('ambientalForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aqui você implementará a lógica de salvamento
            alert('Indicadores salvos com sucesso!');
            window.location.href = 'visualizar-ambiental.html';
        });
    </script>
</body>
</html> 