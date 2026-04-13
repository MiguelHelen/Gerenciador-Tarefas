@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=Patrick+Hand&display=swap');

    body {
        overflow-x: hidden;
    }

    .notebook-bg {
        min-height: 100vh;
        background: #f5f0e8;
        background-image:
            radial-gradient(circle at 30% 20%, rgba(210, 180, 140, 0.4) 0%, transparent 50%),
            radial-gradient(circle at 70% 80%, rgba(188, 170, 150, 0.3) 0%, transparent 50%);
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 20px 60px;
        position: relative;
    }

    .notebook-bg::before {
        content: '';
        position: fixed;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%239C8B75' fill-opacity='0.04'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z'/%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
    }

    
    .scroll-indicator {
        position: fixed;
        bottom: 24px;
        right: 30px;
        z-index: 100;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        animation: fadeInOut 3s ease-in-out infinite;
        transition: opacity 0.5s ease;
    }

    .scroll-indicator.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .scroll-indicator span {
        font-family: 'Patrick Hand', cursive;
        font-size: 0.85rem;
        color: #8b7355;
        background: rgba(255,255,255,0.8);
        padding: 2px 10px;
        border-radius: 10px;
    }

    .scroll-mouse {
        width: 24px;
        height: 38px;
        border: 2px solid #8b7355;
        border-radius: 12px;
        position: relative;
        background: rgba(255, 255, 255, 0.7);
    }

    .scroll-mouse::before {
        content: '';
        position: absolute;
        top: 7px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 8px;
        background: #8b7355;
        border-radius: 4px;
        animation: scroll-wheel 2s ease-in-out infinite;
    }

    @keyframes scroll-wheel {
        0%   { opacity: 1; top: 7px; }
        100% { opacity: 0; top: 20px; }
    }

    @keyframes fadeInOut {
        0%, 100% { opacity: 0.5; }
        50%       { opacity: 1; }
    }

    
    .notebook-wrapper {
        position: relative;
        z-index: 2;
        max-width: 720px;
        width: 100%;
        display: flex;         
        align-items: stretch;  
    }

    /* ─── Espiral ─── */
    .spiral-binding {
        
        flex-shrink: 0;       
        width: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-around; 
        padding: 24px 0;
        position: relative;
        z-index: 5;
    }

    .spiral-ring {
        width: 26px;
        height: 26px;
        border: 3px solid #888;
        border-radius: 50%;
        background: linear-gradient(135deg, #ccc, #999);
        box-shadow: 1px 2px 4px rgba(0,0,0,0.3), inset 0 1px 2px rgba(255,255,255,0.5);
        flex-shrink: 0; /* novo */
    }

    /* ─── Folha ─── */
    .notebook-page {
        flex: 1;              
        background: #fffef5;
        border-radius: 0 12px 12px 0;  
        box-shadow:
            5px 5px 20px rgba(0,0,0,0.15),
            inset 0 0 60px rgba(0,0,0,0.02);
        padding: 50px 50px 60px 44px;
        position: relative;
        overflow: hidden;      
    }

    /* Margem vermelha */
    .notebook-page::before {
        content: '';
        position: absolute;
        left: 26px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e74c3c;
        opacity: 0.6;
        z-index: 1;
    }

    /* Linhas azuis */
    .notebook-page::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(
            transparent,
            transparent 31px,
            #c8d8e8 31px,
            #c8d8e8 32px
        );
        background-position: 0 48px;
        pointer-events: none;
        z-index: 0;
    }

    /* ─── Conteúdo ─── */
    .notebook-content {
        position: relative;
        z-index: 2;
    }

    .notebook-title {
        font-family: 'Caveat', cursive;
        font-size: 3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .notebook-date {
        font-family: 'Patrick Hand', cursive;
        font-size: 1rem;
        color: #95a5a6;
        margin-bottom: 28px;
        display: block;
    }

    .notebook-text {
        font-family: 'Patrick Hand', cursive;
        font-size: 1.2rem;
        color: #34495e;
        line-height: 2.05;
        margin-bottom: 0;
    }

    .notebook-text .highlight {
        background: linear-gradient(180deg, transparent 60%, #fff3a8 60%);
        padding: 0 4px;
    }

    .notebook-text .underline-red {
        text-decoration: underline;
        text-decoration-color: #e74c3c;
        text-underline-offset: 3px;
    }

    .notebook-text .crossed {
        text-decoration: line-through;
        color: #95a5a6;
    }

    .notebook-divider {
        border: none;
        border-top: 1px dashed #bdc3c7;
        margin: 20px 0;
    }

    .notebook-list {
        font-family: 'Patrick Hand', cursive;
        font-size: 1.15rem;
        color: #34495e;
        line-height: 2.1;
        list-style: none;
        padding: 0;
        margin: 10px 0 20px;
    }

    .notebook-list li::before {
        content: '✓ ';
        color: #27ae60;
        font-weight: bold;
    }

    .notebook-list li.unchecked::before {
        content: '☐ ';
        color: #7f8c8d;
    }

    /* ─── Botões ─── */
    .buttons-area {
        display: flex;
        gap: 16px;
        margin-top: 28px;
        flex-wrap: wrap;
    }

    .btn-notebook {
        font-family: 'Caveat', cursive;
        font-size: 1.4rem;
        font-weight: 600;
        padding: 12px 32px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-login {
        background: #3498db;
        color: #fff;
        border: 2px solid #2980b9;
        box-shadow: 3px 3px 0px #2471a3;
    }

    .btn-login:hover {
        transform: translate(-2px, -2px);
        box-shadow: 5px 5px 0px #2471a3;
        color: #fff;
        text-decoration: none;
    }

    .btn-cadastrar {
        background: #27ae60;
        color: #fff;
        border: 2px solid #1e8449;
        box-shadow: 3px 3px 0px #196f3d;
    }

    .btn-cadastrar:hover {
        transform: translate(-2px, -2px);
        box-shadow: 5px 5px 0px #196f3d;
        color: #fff;
        text-decoration: none;
    }

    .doodle-arrow {
        font-size: 1.5rem;
        display: inline-block;
        animation: bounce-arrow 1.5s ease-in-out infinite;
        margin-left: 6px;
    }

    @keyframes bounce-arrow {
        0%, 100% { transform: translateX(0); }
        50%       { transform: translateX(6px); }
    }

    /* ─── Stickers ─── */
    .sticker {
        position: absolute;
        z-index: 3;
    }

    .sticker-star {
        top: 30px;
        right: 40px;
        font-size: 2.5rem;
        transform: rotate(15deg);
        animation: wiggle 3s ease-in-out infinite;
    }

    .sticker-pin {
        top: -15px;
        right: 80px;
        font-size: 2rem;
        transform: rotate(-10deg);
    }

    @keyframes wiggle {
        0%, 100% { transform: rotate(15deg); }
        25%       { transform: rotate(20deg); }
        75%       { transform: rotate(10deg); }
    }

    .coffee-stain {
        position: absolute;
        bottom: 40px;
        right: 30px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: radial-gradient(circle, transparent 30%, rgba(139,90,43,0.08) 31%, rgba(139,90,43,0.05) 60%, transparent 61%);
        z-index: 3;
    }

    .page-number {
        position: absolute;
        bottom: 20px;
        right: 40px;
        font-family: 'Patrick Hand', cursive;
        font-size: 1rem;
        color: #bdc3c7;
        z-index: 3;
    }

    /* ─── Responsivo ─── */
    @media (max-width: 576px) {
        .notebook-page {
            padding: 40px 24px 50px 36px;
        }

        .notebook-page::before {
            left: 44px;
        }

        .notebook-title {
            font-size: 2.2rem;
        }

        .spiral-binding {
            width: 28px;
        }

        .buttons-area {
            flex-direction: column;
        }

        .btn-notebook {
            justify-content: center;
        }

        .scroll-indicator {
            right: 16px;
            bottom: 16px;
        }
    }

   
footer {
    display: none !important;
}


html, body {
    height: 100%;
    
}

.notebook-bg {
    height: 100%;
   
}
</style>

<div class="notebook-bg">

    <div class="scroll-indicator" id="scrollIndicator">
        <span>Role para baixo</span>
        <div class="scroll-mouse"></div>
    </div>

    <div class="notebook-wrapper">

        
        <div class="spiral-binding">
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
            <div class="spiral-ring"></div>
        </div>

        
        <div class="notebook-page">
            <div class="sticker sticker-star">⭐</div>
            <div class="sticker sticker-pin">📌</div>
            <div class="coffee-stain"></div>

            <div class="notebook-content">
                <h1 class="notebook-title">📒 Meu Bloco de Notas</h1>
                <span class="notebook-date">{{  now()->translatedFormat('d \d\e F \d\e Y') }}</span>

                <p class="notebook-text">
                    Bem-vindo ao seu <span class="highlight">bloco de notas pessoal</span>!
                    Aqui você pode guardar todas as suas ideias, lembretes
                    e pensamentos em um lugar só.
                </p>

                <hr class="notebook-divider">

                <p class="notebook-text">
                    <span class="underline-red">Como funciona?</span> É muito simples!
                    Basta criar sua conta, fazer login e começar a
                    escrever. Suas anotações ficam salvas com segurança
                    no nosso sistema.
                </p>

                <p class="notebook-text">
                    Sabe aquela ideia que aparece do nada no meio do dia?
                    Ou aquele lembrete importante que você não pode esquecer?
                    É pra isso que estamos aqui — um cantinho digital só seu,
                    onde cada pensamento tem espaço garantido.
                </p>

                <hr class="notebook-divider">

                <p class="notebook-text">O que você pode fazer por aqui:</p>

                <ul class="notebook-list">
                    <li>Criar novas anotações rapidamente</li>
                    <li>Editar suas notas quando quiser</li>
                    <li>Organizar seus pensamentos do dia a dia</li>
                    <li>Excluir o que não precisa mais</li>
                    <li class="unchecked">Acessar de qualquer lugar</li>
                    <li class="unchecked">Nunca mais perder uma ideia</li>
                </ul>

                <hr class="notebook-divider">

                <p class="notebook-text">
                    <span class="crossed">Usar papel e caneta</span> — Agora tudo é digital!
                    Chega de perder anotações em papéis soltos pela mesa.
                    Com o nosso bloco de notas online, suas ideias estão
                    sempre organizadas e acessíveis.
                </p>

                <p class="notebook-text">
                    Imagine ter um caderno que nunca acaba, que nunca se perde,
                    e que você pode abrir de qualquer computador ou celular —
                    é exatamente isso que oferecemos.
                </p>

                <hr class="notebook-divider">

                <p class="notebook-text">
                    💡 <span class="highlight">Dica:</span> Anote tudo que vier à mente!
                    Desde listas de compras até aquela ideia genial que
                    aparece no meio da madrugada.
                </p>

                <p class="notebook-text">
                    🎯 <span class="highlight">Lembrete:</span> Quanto mais você anota,
                    mais organizada fica sua vida. Então não perca tempo —
                    comece agora!
                </p>

                <hr class="notebook-divider">

                <p class="notebook-text">
                    Pronto para começar? Escolha uma opção abaixo! <span class="doodle-arrow">→</span>
                </p>

                <div class="buttons-area">
                    <a href="{{ route('login') }}" class="btn-notebook btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-notebook btn-cadastrar">
                        <i class="fas fa-user-plus"></i> Cadastrar
                    </a>
                </div>
            </div>

            <span class="page-number">pág. 1</span>
        </div>
    </div>
</div>

<script>
    window.addEventListener('scroll', function () {
        var indicator = document.getElementById('scrollIndicator');
        if (window.scrollY > 100) {
            indicator.classList.add('hidden');
        } else {
            indicator.classList.remove('hidden');
        }
    });
</script>
@endsection