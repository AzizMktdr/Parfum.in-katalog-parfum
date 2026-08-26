<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Parfum.in</title>
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
            <h1 class="auth-title">Buat password baru</h1>
            <p class="auth-subtitle">Password minimal 8 karakter.</p>

            @if ($errors->any())
            <div class="auth-errors">
                @foreach ($errors->all() as $error)
                <p class="auth-error-item">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="auth-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="auth-field">
                    <label>Email address</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" placeholder="Enter your email" required>
                </div>

                <div class="auth-field">
                    <label>Password baru</label>
                    <input type="password" name="password" placeholder="••••••" required autofocus>
                </div>

                <div class="auth-field">
                    <label>Konfirmasi password baru</label>
                    <input type="password" name="password_confirmation" placeholder="••••••" required>
                </div>

                <button type="submit" class="auth-btn-primary">Simpan Password Baru</button>

                <p class="auth-switch">Butuh link baru? <a href="{{ route('password.request') }}">Kirim ulang</a></p>
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
