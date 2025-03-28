<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fa-solid fa-circle-user me-2"></i>Sistema de Indicadores
            </a>
            <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/visualizar-usuarios">
                            <i class="fa-solid fa-circle-user"></i> &nbsp Visualizar Usuarios
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
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4" style="color: var(--secondary-color);">Registrar Novo Usuário</h3>
                <form action="{{ route('user.cadastrar') }}" method = "POST" id = "userForm">
                    @csrf
                    <!-- Campo de Usuário -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Digite o nome de usuário">
                    </div>
                    
                    <!-- Campo de Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu email">
                    </div>
                    
                    <!-- Campo de Senha -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Digite sua senha">
                    </div>
                    
                    <!-- Campo de Setor -->
                    <div class="mb-3">
                        <label for="sector" class="form-label">Setor</label>
                        <select class="form-select" id="setor" name="setor" required>
                            <option value="" disabled selected>Selecione um setor</option>
                            <option value="admin">admin</option>
                            <option value="comercial">Comercial</option>
                            <option value="seguranca">Segurança</option>
                            <option value="exames">Recepção</option>
                            <option value="ambiental">Ambiental</option>
                            <option value="admin">Gerência</option>
                        </select>
                    </div>
                    
                    <!-- Botões de Ação -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-secondary">Limpar</button>
                    </div>
                </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Previne o envio padrão do formulário

            const formData = new FormData(this); // Cria o FormData com os dados do formulário

            fetch('{{ route('user.cadastrar') }}', { // Aponte para a rota de cadastro
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
                console.error('Erro ao cadastrar exame:', error); // Loga qualquer erro
            });
        });
    </script>

</body>
</html>
