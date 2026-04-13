<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gerenciador de Tarefas')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding-bottom: 60px;
        }

        /* Efeito de papel rasgado no topo */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-bottom: 3px solid #ffd700;
        }

        .navbar-brand {
            font-family: 'Indie Flower', cursive;
            font-size: 1.8rem;
            color: #667eea !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        /* Container principal com efeito de papel */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Cards estilo post-it */
        .task-card {
            background: #fff9c4;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
            transform: rotate(0deg);
        }

        .task-card:hover {
            transform: translateY(-5px) rotate(0deg);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }

        /* Cores diferentes para cada tarefa */
        .task-card.color-1 { background: #fff9c4; }
        .task-card.color-2 { background: #ffccbc; }
        .task-card.color-3 { background: #c8e6e9; }
        .task-card.color-4 { background: #d1c4e9; }
        .task-card.color-5 { background: #c8e6c9; }
        .task-card.color-6 { background: #ffecb3; }

        /* Efeito de papel rasgado na parte inferior */
        .task-card::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: repeating-linear-gradient(45deg, 
                rgba(0,0,0,0.05) 0px, 
                rgba(0,0,0,0.05) 10px,
                transparent 10px,
                transparent 20px);
            pointer-events: none;
        }

        /* Fita adesiva no canto */
        .task-card::after {
            content: '';
            position: absolute;
            top: -5px;
            right: 20px;
            width: 60px;
            height: 30px;
            background: rgba(255,255,200,0.6);
            transform: rotate(5deg);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            pointer-events: none;
        }

        .card-header {
            background: transparent;
            border-bottom: 2px dashed rgba(0,0,0,0.1);
            padding: 1rem;
            font-weight: bold;
        }

        .task-title {
            font-family: 'Indie Flower', cursive;
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin: 0;
            word-break: break-word;
        }

        .task-title.completed {
            text-decoration: line-through;
            opacity: 0.7;
        }

        .task-description {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.6;
            margin-top: 10px;
        }

        /* Badges estilizadas */
        .priority-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .priority-alta {
            background: #ff4757;
            color: white;
            box-shadow: 0 2px 5px rgba(255,71,87,0.3);
        }

        .priority-media {
            background: #ffa502;
            color: white;
            box-shadow: 0 2px 5px rgba(255,165,2,0.3);
        }

        .priority-baixa {
            background: #26de81;
            color: white;
            box-shadow: 0 2px 5px rgba(38,222,129,0.3);
        }

        /* Botões com espaçamento */
        .task-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .btn-task {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-task i {
            font-size: 0.9rem;
        }

        .btn-task:hover {
            transform: translateY(-2px);
            filter: brightness(95%);
        }

        .btn-complete {
            background: #26de81;
            color: white;
        }

        .btn-edit {
            background: #70a1ff;
            color: white;
        }

        .btn-delete {
            background: #ff4757;
            color: white;
        }

        .btn-reopen {
            background: #ffa502;
            color: white;
        }

        /* Filtros estilizados */
        .filter-section {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .filter-select {
            border-radius: 25px;
            padding: 10px 20px;
            border: 2px solid #e0e0e0;
            background: white;
            transition: all 0.3s;
        }

        .filter-select:focus {
            border-color: #667eea;
            box-shadow: none;
        }

        .btn-filter {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 25px;
            padding: 10px 25px;
            border: none;
            transition: all 0.3s;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }

        /* Botão nova tarefa */
        .btn-create {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: bold;
            border: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102,126,234,0.4);
            color: white;
        }

        /* Data limite */
        .task-date {
            font-size: 0.8rem;
            color: #666;
            margin-top: 10px;
            padding: 5px 0;
            border-top: 1px dashed rgba(0,0,0,0.1);
        }

        .task-date i {
            margin-right: 5px;
        }

        .date-overdue {
            color: #ff4757;
            font-weight: bold;
        }

        /* Paginação estilizada */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        .page-link {
            border-radius: 25px !important;
            margin: 0 5px;
            color: #667eea;
            border: none;
            padding: 8px 16px;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        /* Alertas estilizados */
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Footer */
        /* Footer Fixo Melhorado */
footer {
    background: rgba(0, 0, 0, 0.85);
    color: white;
    text-align: center;
    padding: 15px;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    backdrop-filter: blur(10px);
    font-size: 0.9rem;
    box-shadow: 0 -5px 20px rgba(0,0,0,0.2);
}

footer p {
    margin: 0;
}

footer a {
    color: #ffd700;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

/* Garantir que o conteúdo não fique atrás do footer */
body {
    padding-bottom: 60px;
}

/* Responsivo */
@media (max-width: 768px) {
    footer {
        padding: 10px;
        font-size: 0.8rem;
    }
    
    body {
        padding-bottom: 70px;
    }
    
    .main-container {
        margin-bottom: 0;
    }
}

        /* Responsividade */
        @media (max-width: 768px) {
            .task-actions {
                flex-direction: column;
            }
            
            .btn-task {
                width: 100%;
                justify-content: center;
            }
            
            .main-container {
                padding: 1rem;
                margin-bottom: 80px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-sticky-note"></i> Notas & Tarefas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tasks.index') }}">
                                <i class="fas fa-list"></i> Minhas Notas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tasks.create') }}">
                                <i class="fas fa-plus-circle"></i> Nova Nota
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Cadastro</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="main-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Notas & Tarefas - Organize suas ideias com estilo</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>