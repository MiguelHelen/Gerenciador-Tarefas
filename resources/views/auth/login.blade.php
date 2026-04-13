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

    .login-bg {
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

    /* Linhas de caderno no fundo */
    .login-bg::before {
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

    /* ── Wrapper com espiral + folha ── */
    .login-wrapper {
        position: relative;
        z-index: 2;
        max-width: 520px;
        width: 100%;
        display: flex;
        align-items: stretch;
    }

    /* Espiral */
    .login-spiral {
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
    .login-page {
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
    .login-page::before {
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
    .login-page::after {
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

    .login-content {
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

    /* Título */
    .login-title {
        font-family: 'Caveat', cursive;
        font-size: 2.6rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .login-subtitle {
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
        border-bottom-color: #3498db;
        background: rgba(52, 152, 219, 0.04);
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

    /* Checkbox */
    .remember-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 28px;
    }

    .notebook-checkbox {
        width: 18px;
        height: 18px;
        accent-color: #3498db;
        cursor: pointer;
    }

    .remember-label {
        font-family: 'Patrick Hand', cursive;
        font-size: 1.05rem;
        color: #555;
        cursor: pointer;
    }

    /* Botões */
    .btn-login-main {
        font-family: 'Caveat', cursive;
        font-size: 1.45rem;
        font-weight: 600;
        width: 100%;
        padding: 13px 24px;
        background: #3498db;
        color: #fff;
        border: none;
        border-radius: 8px;
        box-shadow: 4px 4px 0 #2471a3;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .btn-login-main:hover {
        transform: translate(-2px, -2px);
        box-shadow: 6px 6px 0 #2471a3;
        color: #fff;
    }

    .btn-forgot {
        font-family: 'Patrick Hand', cursive;
        font-size: 1rem;
        color: #95a5a6;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: color 0.2s;
    }

    .btn-forgot:hover {
        color: #3498db;
        text-decoration: underline;
    }

    /* Divisor */
    .notebook-divider {
        border: none;
        border-top: 1px dashed #bdc3c7;
        margin: 24px 0;
    }

    .register-row {
        text-align: center;
        font-family: 'Patrick Hand', cursive;
        font-size: 1.05rem;
        color: #7a7060;
    }

    .register-row a {
        color: #27ae60;
        font-weight: 600;
        text-decoration: none;
    }

    .register-row a:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .login-page {
            padding: 36px 28px 40px 32px;
        }
        .login-title {
            font-size: 2rem;
        }
    }
    html, body {
    height: 100%;
    overflow: hidden; /* mantém */
}

.login-bg {
    height: 100%;
    overflow-y: auto; /* ← já estava, é isso que dá o scroll */
}
</style>

<div class="login-bg">
    <div class="login-wrapper">

        <!-- Espiral -->
        <div class="login-spiral">
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
        <div class="login-page">
            <div class="deco-pin">📌</div>

            <div class="login-content">
                <h1 class="login-title">📒 Entrar na conta</h1>
                <span class="login-subtitle">Anote. Organize. Não esqueça nada.</span>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <label for="email" class="field-label">✉️ Endereço de e-mail</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
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
<div style="position: relative;">
    <input
        id="password"
        type="password"
        name="password"
        required
        autocomplete="current-password"
        class="notebook-input @error('password') is-invalid @enderror"
        placeholder="••••••••"
        style="padding-right: 36px;"
    >
    <button
        type="button"
        id="togglePassword"
        style="
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
        "
        onclick="
            const input = document.getElementById('password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            this.innerHTML = isHidden
                ? '<i class=\'fas fa-eye-slash\'></i>'
                : '<i class=\'fas fa-eye\'></i>';
            this.style.color = isHidden ? '#3498db' : '#95a5a6';
        "
    >
        <i class="fas fa-eye"></i>
    </button>
</div>
@error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror

                    {{-- Lembrar --}}
                    <div class="remember-row">
                        <input
                            class="notebook-checkbox"
                            type="checkbox"
                            name="remember"
                            id="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="remember-label" for="remember">Lembrar de mim</label>
                    </div>

                    {{-- Botão principal --}}
                    <button type="submit" class="btn-login-main">
                        <i class="fas fa-sign-in-alt"></i> Entrar
                    </button>

                    {{-- Esqueci a senha --}}
                    @if (Route::has('password.request'))
                        <a class="btn-forgot" href="{{ route('password.request') }}">
                            Esqueceu sua senha?
                        </a>
                    @endif

                </form>

                <hr class="notebook-divider">

                <p class="register-row">
                    Ainda não tem conta?
                    <a href="{{ route('register') }}">Cadastre-se aqui →</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection