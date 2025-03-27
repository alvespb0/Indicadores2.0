<?php
$setor = Session::get('setor');
$usuario = Session::get('usuario');
if($setor !== 'seguranca' && $setor !== 'admin'){
    header("Location: http://{$_SERVER['HTTP_HOST']}/login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Indicadores - Segurança do Trabalho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-hard-hat me-2"></i>Sistema de Indicadores
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/visualizar-seguranca">
                            <i class="fas fa-chart-bar me-1"></i>Visualizar Indicadores
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
                        <form id="segurancaForm" action="{{ route('seguranca.cadastrar') }}" method="POST">
                            @csrf
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
                                <a href="/visualizar-seguranca" class="btn btn-secondary">
                                    <i class="fas fa-chart-bar me-2"></i>Visualizar Indicadores
                                </a>
                            </div>
                        </form>
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
    <script>
        document.getElementById('segurancaForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Previne o envio padrão do formulário

            const formData = new FormData(this); // Cria o FormData com os dados do formulário

            fetch('{{ route('seguranca.cadastrar') }}', { // Aponte para a rota de cadastro
                method: 'POST',
                body: formData, // Envia o FormData diretamente
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token
                }
            })
            .then(response => response.json()) // Espera pela resposta em JSON
            .then(data => {
                if (data.message) {
                    alert(data.message); // Exibe mensagem de sucesso
                } else if (data.error) {
                    alert(data.error); // Exibe mensagem de erro
                }
            })
            .catch(error => {
                console.error('Erro ao cadastrar indicador:', error); // Loga qualquer erro
            });
        });

    </script>
</body>
</html> 