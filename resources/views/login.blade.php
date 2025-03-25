<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistema de Indicadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-chart-line sector-icon"></i>
                            <h2 class="card-title">Login</h2>
                        </div>
                        <form id="loginForm" method = "POST" action = "{{ route('user.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="setor" class="form-label">Setor</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <select class="form-select" id="sector" name="sector" required>
                                        <option value="" disabled selected>Selecione o setor</option>
                                        <option value="admin">admin</option>
                                        <option value="exames">Recepção</option>
                                        <option value="comercial">Comercial</option>
                                        <option value="seguranca">Segurança do Trabalho</option>
                                        <option value="ambiental">Ambiental</option>
                                        <option value="gerencia">Gerencia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Entrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Previne o envio padrão do formulário

            const formData = new FormData(this); // Cria o FormData com os dados do formulário

            fetch('{{ route('user.login') }}', { // Aponte para a rota de cadastro
                method: 'POST',
                body: formData, // Envia o FormData diretamente
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }

            })
            .then(response => response.json()) // Espera pela resposta em JSON
            .then(data => {
                if (data.message) {
                    alert(data.message); // Exibe mensagem de sucesso
                    window.location.href = '/';
                } else if (data.error) {
                    alert(data.error); // Exibe mensagem de erro
                }
            })
            .catch(error => {
                console.error('Erro ao fazer login:', error); // Loga qualquer erro
            });
        });
    </script>
</body>
</html> 