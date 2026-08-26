<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — Parfum.in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

<div class="auth-page">
    {{-- Kiri: Form --}}
    <div class="auth-form-side">
        <a href="{{ route('home') }}" class="auth-back">← Back</a>

        <div class="auth-form-wrap">
            <h1 class="auth-title">Get Started Now</h1>

            
                @if ($errors->any())
                <div class="auth-errors">
                    @foreach ($errors->all() as $error)
                    <p class="auth-error-item">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

            <form method="POST" action="{{ route('register.post') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>

                <div class="auth-field">
                    <label>Email address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="auth-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••" required>
                </div>

                <div class="auth-field">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••" required>
                </div>

                <div class="auth-checkbox">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">I agree to the <a href="#">terms & policy</a></label>
                </div>

                <button type="submit" class="auth-btn-primary">Signup</button>

                <div class="auth-or"><span>or</span></div>

                <div class="auth-socials">
                    <button type="button" class="auth-social-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        Sign in with Google
                    </button>
                    <button type="button" class="auth-social-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                        Sign in with Apple
                    </button>
                </div>

                <p class="auth-switch">Have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </form>
        </div>
    </div>

    {{-- Kanan: Gambar --}}
    <div class="auth-image-side">
        {{--
        ╔══════════════════════════════════════════════════════╗
        ║  📁 GAMBAR SIGNUP:                                   ║
        ║     public/images/auth/signup-bg.jpg                 ║
        ║     Foto parfum dengan latar bokeh/kayu              ║
        ╚══════════════════════════════════════════════════════╝
        --}}
        <img src="{{ asset('images/auth/signup-bg.jpg') }}"
             alt="Parfum"
             onerror="this.parentElement.style.background='linear-gradient(135deg,#d4c4a8,#a89070)'">
    </div>
</div>

</body>
</html>
