@extends('layouts.app')
@section('title', 'Profil Saya — Parfum.in')

@push('styles')
<style>
    .profile-page { max-width: 780px; margin: 0 auto; padding: 120px 24px 80px; }
    .profile-title { font-size: 28px; font-weight: 700; letter-spacing: .02em; margin-bottom: 6px; }
    .profile-subtitle { font-size: 13px; opacity: .65; margin-bottom: 32px; }
    .profile-card { border: 1px solid rgba(128,128,128,.25); border-radius: 14px; padding: 26px; margin-bottom: 24px; }
    .profile-card h2 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
    .profile-card .hint { font-size: 12px; opacity: .6; margin-bottom: 20px; }
    .profile-field { margin-bottom: 16px; }
    .profile-field label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; opacity: .8; }
    .profile-field input[type="text"],
    .profile-field input[type="email"],
    .profile-field input[type="password"],
    .profile-field input[type="file"] {
        width: 100%; padding: 11px 13px; font: inherit; font-size: 14px;
        border: 1px solid rgba(128,128,128,.35); border-radius: 9px;
        background: transparent; color: inherit;
    }
    .profile-avatar-row { display: flex; align-items: center; gap: 16px; margin-bottom: 18px; }
    .profile-avatar { width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 1px solid rgba(128,128,128,.3); }
    .profile-avatar-fallback {
        width: 68px; height: 68px; border-radius: 50%; display: grid; place-items: center;
        font-size: 24px; font-weight: 700; background: rgba(128,128,128,.18);
    }
    .profile-check { display: flex; align-items: center; gap: 8px; font-size: 12px; opacity: .8; margin-bottom: 18px; }
    .profile-btn {
        padding: 11px 22px; font: inherit; font-size: 13px; font-weight: 600; letter-spacing: .04em;
        border: none; border-radius: 9px; cursor: pointer; background: #1a1a1a; color: #fff;
    }
    .profile-btn:hover { opacity: .88; }
    .profile-errors { border: 1px solid #c62828; background: rgba(198,40,40,.08); border-radius: 9px; padding: 12px 14px; margin-bottom: 20px; }
    .profile-errors p { color: #c62828; font-size: 12px; margin: 2px 0; }
    .profile-meta { font-size: 12px; opacity: .6; margin-top: 18px; }
</style>
@endpush

@section('content')
<div class="profile-page">
    <h1 class="profile-title">Profil Saya</h1>
    <p class="profile-subtitle">
        Kelola data akun, avatar, dan password Anda.
        &middot; <a href="{{ route('profile.show', $user->route_handle) }}" style="color:inherit">Lihat profil publik &rsaquo;</a>
    </p>

    @if (session('success'))
    <div style="border:1px solid #2e7d32;background:rgba(46,125,50,.08);border-radius:9px;padding:12px 14px;margin-bottom:20px;font-size:12px;color:#2e7d32;">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="profile-errors">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Data akun --}}
    <div class="profile-card">
        <h2>Data Akun</h2>
        <p class="hint">Nama, email, dan foto profil.</p>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="profile-avatar-row">
                @if ($user->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}" class="profile-avatar">
                @else
                <div class="profile-avatar-fallback">{{ $user->initial }}</div>
                @endif

                <div style="flex:1">
                    <div class="profile-field" style="margin-bottom:0">
                        <label for="avatar">Ganti avatar (maks 2 MB)</label>
                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/webp">
                    </div>
                </div>
            </div>

            @if ($user->avatar)
            <div class="profile-check">
                <input type="checkbox" id="remove_avatar" name="remove_avatar" value="1">
                <label for="remove_avatar" style="margin:0">Hapus avatar saat ini</label>
            </div>
            @endif

            <div class="profile-field">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="profile-field">
                <label for="username">Username <span style="opacity:.55;font-weight:400">— dipakai di URL profil publik</span></label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                       placeholder="mis. budi_santoso" minlength="3" maxlength="30">
            </div>

            <div class="profile-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="profile-field">
                <label for="bio">Bio <span style="opacity:.55;font-weight:400">— maksimal 200 karakter</span></label>
                <textarea id="bio" name="bio" rows="3" maxlength="200"
                          style="width:100%;padding:11px 13px;font:inherit;font-size:14px;border:1px solid rgba(128,128,128,.35);border-radius:9px;background:transparent;color:inherit;resize:vertical;">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <button type="submit" class="profile-btn">Simpan Perubahan</button>

            <p class="profile-meta">
                Bergabung {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}
                · {{ $user->favorites()->count() }} favorit
                · {{ $user->reviews()->count() }} review
            </p>
        </form>
    </div>

    {{-- Ganti password --}}
    <div class="profile-card">
        <h2>Ganti Password</h2>
        <p class="hint">Masukkan password saat ini untuk konfirmasi. Password baru minimal 8 karakter.</p>

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <div class="profile-field">
                <label for="current_password">Password saat ini</label>
                <input type="password" id="current_password" name="current_password" required>
            </div>

            <div class="profile-field">
                <label for="new_password">Password baru</label>
                <input type="password" id="new_password" name="password" required>
            </div>

            <div class="profile-field">
                <label for="password_confirmation">Konfirmasi password baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="profile-btn">Ganti Password</button>
        </form>
    </div>
</div>
@endsection
