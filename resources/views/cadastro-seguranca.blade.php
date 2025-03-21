<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Indicadores - Segurança do Trabalho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-hard-hat me-2"></i>Sistema de Indicadores
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
            <h1 class="sector-title">Segurança do Trabalho</h1>
            <p class="sector-subtitle">Cadastro de Indicadores</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form id="segurancaForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="levantamentosRealizados" class="form-label">
                                        <i class="fas fa-clipboard-check me-2"></i>Levantamentos Realizados
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-clipboard-list"></i>
                                        </span>
                                        <input type="number" class="form-control" id="levantamentosRealizados" name="levantamentosRealizados" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="treinamentosRealizados" class="form-label">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Treinamentos Realizados
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-graduation-cap"></i>
                                        </span>
                                        <input type="number" class="form-control" id="treinamentosRealizados" name="treinamentosRealizados" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="laudosVendidos" class="form-label">
                                        <i class="fas fa-file-invoice me-2"></i>Laudos Vendidos
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-file-alt"></i>
                                        </span>
                                        <input type="number" class="form-control" id="laudosVendidos" name="laudosVendidos" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="laudosEmitidos" class="form-label">
                                        <i class="fas fa-file-signature me-2"></i>Laudos Emitidos
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <input type="number" class="form-control" id="laudosEmitidos" name="laudosEmitidos" required>
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
                                <a href="visualizar-seguranca.html" class="btn btn-secondary">
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
        document.getElementById('segurancaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aqui você implementará a lógica de salvamento
            alert('Indicadores salvos com sucesso!');
            window.location.href = 'visualizar-seguranca.html';
        });
    </script>
</body>
</html> 