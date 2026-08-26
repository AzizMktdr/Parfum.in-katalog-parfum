<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — Parfum.in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

<div class="auth-page">
    {{-- Kiri: Form --}}
    <div class="auth-form-side">
        <a href="{{ route('login') }}" class="auth-back">← Back to login</a>

        <div class="auth-form-wrap">
            <h1 class="auth-title">Lupa password?</h1>
            <p class="auth-subtitle">Masukkan email akun Anda, kami kirimkan link untuk membuat password baru.</p>

            @if (session('status'))
            <div class="auth-errors" style="border-color:#2e7d32;background:#e8f5e9">
                <p class="auth-error-item" style="color:#2e7d32">{{ session('status') }}</p>
            </div>
            @endif

            @if ($errors->any())
            <div class="auth-errors">
                @foreach ($errors->all() as $error)
                <p class="auth-error-item">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf

                <div class="auth-field">
                    <label>Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                </div>

                <button type="submit" class="auth-btn-primary">Kirim Link Reset</button>

                <p class="auth-switch">Sudah ingat password? <a href="{{ route('login') }}">Login</a></p>
            </form>
        </div>
    </div>

    {{-- Kanan: Gambar --}}
    <div class="auth-image-side">
        <img src="{{ asset('images/auth/login-bg.jpg') }}"
             alt="Parfum"
             onerror="this.parentElement.style.background='linear-gradient(135deg,#f5a7a0,#e8854a)'">
    </div>
</div>

</body>
</html>
