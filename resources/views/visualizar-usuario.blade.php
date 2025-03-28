<?php
$setor = Session::get('setor');
$usuario = Session::get('usuario');

if($setor !== 'admin'){
    if($setor !== 'exames' && $setor !== 'admin'){
        header("Location: http://{$_SERVER['HTTP_HOST']}/login");
        exit;
    }
}
/* var_dump($usuarios); */ 
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
                <i class="fa-solid fa-circle-user me-2"></i>Sistema de Indicadores - Usuarios
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/usuario">
                            <i class="fa-solid fa-circle-user"></i> &nbsp Cadastrar Usuarios
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
    <br>
    <div class="container mb-4">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-tittle mb-4">Usuarios cadastrados</h5>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Usuário</th>
                                    <th class="text-center">Setor</th>
                                    <th class="text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuarios as $user)
                                <tr>
                                    <td class="text-center">{{$user->id}}</th>
                                    <td class="text-center">{{$user->usuario}}</td>
                                    <td class="text-center">{{$user->setor}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('usuario.excluir', $user->id)}}" class="btn btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir esse usuario?')">
                                        Excluir
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-1"></div>

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
    @if(session('status') == 'success')
    <script>alert('usuario excluido com sucesso')</script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html> 