@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400;600;700&family=Patrick+Hand&display=swap');

    html, body {
        height: 100%;
        overflow: hidden;
    }

    footer {
        display: none !important;
    }

    .register-bg {
        height: 100%;
        overflow-y: auto;
        background: #f0ebe0;
        background-image:
            radial-gradient(circle at 20% 30%, rgba(255, 220, 100, 0.15) 0%, transparent 45%),
            radial-gradient(circle at 80% 70%, rgba(150, 200, 255, 0.12) 0%, transparent 45%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
    }

    .register-bg::before {
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

    /* ── Wrapper ── */
    .register-wrapper {
        position: relative;
        z-index: 2;
        max-width: 540px;
        width: 100%;
        display: flex;
        align-items: stretch;
    }

    /* Espiral */
    .register-spiral {
        flex-shrink: 0;
        width: 36px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        padding: 20px 0;
        z-index: 5;
    }

    .spiral-ring {
        width: 26px;
        height: 26px;
        border: 3px solid #888;
        border-radius: 50%;
        background: linear-gradient(135deg, #ccc, #999);
        box-shadow: 1px 2px 4px rgba(0,0,0,0.3), inset 0 1px 2px rgba(255,255,255,0.5);
        flex-shrink: 0;
    }

    /* Folha */
    .register-page {
        flex: 1;
        background: #fffef5;
        border-radius: 0 12px 12px 0;
        box-shadow:
            5px 5px 20px rgba(0,0,0,0.15),
            inset 0 0 60px rgba(0,0,0,0.02);
        padding: 44px 44px 48px 40px;
        position: relative;
        overflow: hidden;
    }

    /* Margem vermelha */
    .register-page::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e74c3c;
        opacity: 0.5;
        z-index: 1;
    }

    /* Linhas azuis */
    .register-page::after {
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

    .register-content {
        position: relative;
        z-index: 2;
    }

    /* Decorações */
    .deco-pin {
        position: absolute;
        top: -14px;
        right: 50px;
        font-size: 1.8rem;
        transform: rotate(-8deg);
        z-index: 10;
    }

    .deco-star {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 1.6rem;
        transform: rotate(12deg);
        animation: wiggle 3s ease-in-out infinite;
        z-index: 10;
    }

    @keyframes wiggle {
        0%, 100% { transform: rotate(12deg); }
        50%       { transform: rotate(18deg); }
    }

    /* Título */
    .register-title {
        font-family: 'Caveat', cursive;
        font-size: 2.6rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .register-subtitle {
        font-family: 'Patrick Hand', cursive;
        font-size: 1rem;
        color: #95a5a6;
        margin-bottom: 32px;
        display: block;
    }

    /* Labels */
    .field-label {
        font-family: 'Patrick Hand', cursive;
        font-size: 1.1rem;
        color: #34495e;
        margin-bottom: 6px;
        display: block;
    }

    /* Inputs */
    .notebook-input {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 2px solid #bdc3c7;
        border-radius: 0;
        padding: 8px 4px;
        font-family: 'Patrick Hand', cursive;
        font-size: 1.1rem;
        color: #2c2c2c;
        outline: none;
        transition: border-color 0.2s ease;
        margin-bottom: 24px;
    }

    .notebook-input:focus {
        border-bottom-color: #27ae60;
        background: rgba(39, 174, 96, 0.04);
    }

    .notebook-input.is-invalid {
        border-bottom-color: #e74c3c;
    }

    .invalid-feedback {
        font-family: 'Patrick Hand', cursive;
        font-size: 0.95rem;
        color: #e74c3c;
        margin-top: -18px;
        margin-bottom: 16px;
        display: block;
    }

    /* Wrapper do input com olhinho */
    .input-eye-wrapper {
        position: relative;
    }

    .input-eye-wrapper .notebook-input {
        padding-right: 36px;
    }

    .btn-eye {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-60%);
        background: none;
        border: none;
        cursor: pointer;
        color: #95a5a6;
        font-size: 1rem;
        padding: 4px;
        transition: color 0.2s;
    }

    .btn-eye:hover {
        color: #27ae60;
    }

    /* Indicador de força da senha */
    .strength-bar-wrap {
        display: flex;
        gap: 4px;
        margin-top: -18px;
        margin-bottom: 20px;
    }

    .strength-bar-wrap .bar {
        height: 4px;
        flex: 1;
        border-radius: 4px;
        background: #e0e0e0;
        transition: background 0.3s ease;
    }

    .strength-label {
        font-family: 'Patrick Hand', cursive;
        font-size: 0.88rem;
        margin-bottom: 20px;
        margin-top: -14px;
        display: block;
        transition: color 0.3s;
    }

    /* Botão principal */
    .btn-register-main {
        font-family: 'Caveat', cursive;
        font-size: 1.45rem;
        font-weight: 600;
        width: 100%;
        padding: 13px 24px;
        background: #27ae60;
        color: #fff;
        border: none;
        border-radius: 8px;
        box-shadow: 4px 4px 0 #196f3d;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .btn-register-main:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 #196f3d;
        color: #fff;
    }

    /* Divisor */
    .notebook-divider {
        border: none;
        border-top: 1px dashed #bdc3c7;
        margin: 24px 0;
    }

    .login-row {
        text-align: center;
        font-family: 'Patrick Hand', cursive;
        font-size: 1.05rem;
        color: #7a7060;
    }

    .login-row a {
        color: #3498db;
        font-weight: 600;
        text-decoration: none;
    }

    .login-row a:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .register-page {
            padding: 36px 28px 40px 32px;
        }
        .register-title {
            font-size: 2rem;
        }
    }
</style>

<div class="register-bg">
    <div class="register-wrapper">

        <!-- Espiral -->
        <div class="register-spiral">
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

        <!-- Folha -->
        <div class="register-page">
            <div class="deco-pin">📌</div>
            <div class="deco-star">⭐</div>

            <div class="register-content">
                <h1 class="register-title">✏️ Criar conta</h1>
                <span class="register-subtitle">Comece a organizar suas ideias agora!</span>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nome --}}
                    <label for="name" class="field-label">👤 Nome completo</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        autofocus
                        class="notebook-input @error('name') is-invalid @enderror"
                        placeholder="Como você se chama?"
                    >
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- Email --}}
                    <label for="email" class="field-label">✉️ Endereço de e-mail</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="notebook-input @error('email') is-invalid @enderror"
                        placeholder="seu@email.com"
                    >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- Senha --}}
                    <label for="password" class="field-label">🔒 Senha</label>
                    <div class="input-eye-wrapper">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="notebook-input @error('password') is-invalid @enderror"
                            placeholder="Crie uma senha forte"
                            oninput="checkStrength(this.value)"
                        >
                        <button type="button" class="btn-eye" onclick="toggleEye('password', 'eye1')">
                            <i class="fas fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    {{-- Barra de força --}}
                    <div class="strength-bar-wrap">
                        <div class="bar" id="bar1"></div>
                        <div class="bar" id="bar2"></div>
                        <div class="bar" id="bar3"></div>
                        <div class="bar" id="bar4"></div>
                    </div>
                    <span class="strength-label" id="strengthLabel" style="color: #bdc3c7;">
                        Digite uma senha...
                    </span>

                    {{-- Confirmar senha --}}
                    <label for="password-confirm" class="field-label">🔑 Confirmar senha</label>
                    <div class="input-eye-wrapper">
                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="notebook-input"
                            placeholder="Repita a senha"
                        >
                        <button type="button" class="btn-eye" onclick="toggleEye('password-confirm', 'eye2')">
                            <i class="fas fa-eye" id="eye2"></i>
                        </button>
                    </div>

                    {{-- Botão --}}
                    <button type="submit" class="btn-register-main">
                        <i class="fas fa-user-plus"></i> Criar minha conta
                    </button>

                </form>

                <hr class="notebook-divider">

                <p class="login-row">
                    Já tem uma conta?
                    <a href="{{ route('login') }}">← Fazer login</a>
                </p>
            </div>
        </div>

    </div>
</div>

<script>
    // Olhinho
    function toggleEye(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const isHidden = input.type === 'password';
        input.type  = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        icon.closest('button').style.color = isHidden ? '#27ae60' : '#95a5a6';
    }

    // Força da senha
    function checkStrength(val) {
        const bars  = [1,2,3,4].map(i => document.getElementById('bar' + i));
        const label = document.getElementById('strengthLabel');

        const checks = [
            val.length >= 8,
            /[A-Z]/.test(val),
            /[0-9]/.test(val),
            /[^A-Za-z0-9]/.test(val),
        ];

        const score = checks.filter(Boolean).length;

        const colors = ['#e74c3c', '#e67e22', '#f1c40f', '#27ae60'];
        const labels = ['Fraca', 'Razoável', 'Boa', 'Forte 💪'];

        bars.forEach((bar, i) => {
            bar.style.background = i < score ? colors[score - 1] : '#e0e0e0';
        });

        label.textContent = val.length === 0 ? 'Digite uma senha...' : labels[score - 1] ?? 'Fraca';
        label.style.color = val.length === 0 ? '#bdc3c7' : colors[score - 1];
    }
</script>

@endsection