@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=Patrick+Hand&display=swap');

    .dash-bg {
        min-height: 100vh;
        background: #f0ebe0;
        background-image:
            radial-gradient(circle at 20% 30%, rgba(255, 220, 100, 0.15) 0%, transparent 45%),
            radial-gradient(circle at 80% 70%, rgba(150, 200, 255, 0.12) 0%, transparent 45%);
        padding: 48px 24px 80px;
        position: relative;
        overflow: hidden;
    }

    /* Linhas de fundo estilo caderno */
    .dash-bg::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: repeating-linear-gradient(
            transparent,
            transparent 39px,
            rgba(180, 210, 230, 0.35) 39px,
            rgba(180, 210, 230, 0.35) 40px
        );
        background-position: 0 20px;
        pointer-events: none;
        z-index: 0;
    }

    .dash-container {
        max-width: 860px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    /* ── Cabeçalho ── */
    .dash-header {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 44px;
    }

    .dash-avatar {
        width: 72px;
        height: 72px;
        background: #ffd32a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
        box-shadow: 4px 4px 0 rgba(0,0,0,0.12);
        border: 3px solid rgba(0,0,0,0.08);
        transform: rotate(-3deg);
    }

    .dash-greeting {
        padding-top: 4px;
    }

    .dash-greeting h1 {
        font-family: 'Caveat', cursive;
        font-size: 2.8rem;
        font-weight: 700;
        color: #2c2c2c;
        margin: 0 0 4px;
        line-height: 1.1;
    }

    .dash-greeting p {
        font-family: 'Patrick Hand', cursive;
        font-size: 1.15rem;
        color: #7a7060;
        margin: 0;
    }

    /* ── Cards de estatísticas (post-its) ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 36px;
    }

    .stat-postit {
        padding: 24px 20px 20px;
        border-radius: 2px 12px 2px 2px;
        position: relative;
        box-shadow:
            3px 3px 0 rgba(0,0,0,0.10),
            6px 6px 0 rgba(0,0,0,0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        cursor: default;
    }

    .stat-postit:hover {
        transform: translateY(-4px) rotate(0deg);
        box-shadow:
            5px 8px 0 rgba(0,0,0,0.12),
            10px 14px 0 rgba(0,0,0,0.05);
    }

    /* Dobra no canto superior direito */
    .stat-postit::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 20px;
        height: 20px;
        background: rgba(0,0,0,0.08);
        clip-path: polygon(100% 0, 0 0, 100% 100%);
        border-radius: 0 12px 0 0;
    }

    .stat-postit.yellow { background: #ffe066; transform: rotate(-1.5deg); }
    .stat-postit.blue   { background: #aee6ff; transform: rotate(1deg); }
    .stat-postit.green  { background: #b8f5c8; transform: rotate(-0.5deg); }

    .stat-postit .stat-icon {
        font-size: 1.8rem;
        margin-bottom: 10px;
        display: block;
    }

    .stat-postit .stat-number {
        font-family: 'Caveat', cursive;
        font-size: 3.2rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1;
        display: block;
        margin-bottom: 4px;
    }

    .stat-postit .stat-label {
        font-family: 'Patrick Hand', cursive;
        font-size: 1rem;
        color: #444;
    }

    /* Fita adesiva no topo */
    .stat-postit .tape {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 48px;
        height: 18px;
        background: rgba(255, 255, 255, 0.55);
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 2px;
    }

    /* ── Seção de ações ── */
    .actions-section {
        background: #fffef5;
        border-radius: 4px 12px 12px 4px;
        box-shadow:
            5px 5px 18px rgba(0,0,0,0.10),
            inset 0 0 40px rgba(0,0,0,0.01);
        padding: 36px 40px 40px 52px;
        position: relative;
        overflow: hidden;
    }

    /* Margem vermelha lateral */
    .actions-section::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e74c3c;
        opacity: 0.5;
    }

    /* Linhas da folha dentro da seção */
    .actions-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(
            transparent,
            transparent 39px,
            #c8d8e8 39px,
            #c8d8e8 40px
        );
        background-position: 0 56px;
        pointer-events: none;
        z-index: 0;
    }

    .actions-inner {
        position: relative;
        z-index: 1;
    }

    .actions-title {
        font-family: 'Caveat', cursive;
        font-size: 1.9rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 24px;
    }

    .actions-title span {
        display: inline-block;
        background: linear-gradient(180deg, transparent 55%, #fff3a8 55%);
        padding: 0 6px;
    }

    .btn-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .btn-dash {
        font-family: 'Caveat', cursive;
        font-size: 1.45rem;
        font-weight: 600;
        padding: 16px 24px;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }

    .btn-dash:hover {
        transform: translate(-2px, -2px);
        text-decoration: none;
    }

    .btn-dash i {
        font-size: 1.2rem;
    }

    .btn-ver {
        background: #667eea;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        box-shadow: 4px 4px 0 #4a3d8f;
    }

    .btn-ver:hover {
        color: #fff;
        box-shadow: 6px 6px 0 #4a3d8f;
    }

    .btn-criar {
        background: #26de81;
        color: #fff;
        border: none;
        box-shadow: 4px 4px 0 #17a659;
    }

    .btn-criar:hover {
        color: #fff;
        box-shadow: 6px 6px 0 #17a659;
    }

    /* ── Dica do dia ── */
    .tip-strip {
        margin-top: 28px;
        padding: 14px 18px;
        background: rgba(255, 224, 102, 0.4);
        border-left: 4px solid #ffd32a;
        border-radius: 0 6px 6px 0;
        font-family: 'Patrick Hand', cursive;
        font-size: 1.05rem;
        color: #5a4d00;
    }

    .tip-strip strong {
        font-weight: 700;
    }

    /* ── Decorações ── */
    .deco-pin {
        position: absolute;
        top: -14px;
        right: 60px;
        font-size: 1.8rem;
        transform: rotate(-8deg);
        z-index: 5;
    }

    /* ── Responsivo ── */
    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .btn-grid {
            grid-template-columns: 1fr;
        }

        .dash-greeting h1 {
            font-size: 2rem;
        }

        .actions-section {
            padding: 28px 24px 32px 40px;
        }
    }
    html, body {
    height: 100%;
    
}


.seu-container-principal {
    height: 100%;
   
}

</style>

<div class="dash-bg">
    <div class="dash-container">

        {{-- Cabeçalho --}}
        <div class="dash-header">
            <div class="dash-avatar">😊</div>
            <div class="dash-greeting">
                <h1>Olá, {{ Auth::user()->name }}!</h1>
                <p>Bem-vindo de volta ao seu organizador de notas. O que vamos anotar hoje?</p>
            </div>
        </div>

        {{-- Post-its de estatísticas --}}
        <div class="stats-grid">
            <div class="stat-postit yellow">
                <div class="tape"></div>
                <span class="stat-icon">📋</span>
                <span class="stat-number">{{ Auth::user()->tasks()->count() }}</span>
                <span class="stat-label">Total de Notas</span>
            </div>

            <div class="stat-postit blue">
                <div class="tape"></div>
                <span class="stat-icon">⏳</span>
                <span class="stat-number">{{ Auth::user()->tasks()->pendente()->count() }}</span>
                <span class="stat-label">Notas Pendentes</span>
            </div>

            <div class="stat-postit green">
                <div class="tape"></div>
                <span class="stat-icon">✅</span>
                <span class="stat-number">{{ Auth::user()->tasks()->concluida()->count() }}</span>
                <span class="stat-label">Notas Concluídas</span>
            </div>
        </div>

        {{-- Seção de ações --}}
        <div class="actions-section">
            <div class="deco-pin">📌</div>
            <div class="actions-inner">
                <p class="actions-title">
                    <span>O que você quer fazer?</span>
                </p>

                <div class="btn-grid">
                    <a href="{{ route('tasks.index') }}" class="btn-dash btn-ver">
                        <i class="fas fa-sticky-note"></i> Ver Minhas Notas
                    </a>
                    <a href="{{ route('tasks.create') }}" class="btn-dash btn-criar">
                        <i class="fas fa-plus-circle"></i> Criar Nova Nota
                    </a>
                </div>

                <div class="tip-strip">
                    💡 <strong>Dica:</strong> Anote tudo que vier à cabeça agora — não deixe nenhuma ideia escapar!
                </div>
            </div>
        </div>

    </div>
</div>
@endsection