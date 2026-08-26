<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Parfum.in')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400&display=swap" rel="stylesheet">
    {{-- Asset::css() otomatis pakai versi .min.css (hasil `npm run minify`) di production
         + cache busting ?v=filemtime --}}
    <link rel="stylesheet" href="{{ \App\Support\Asset::css('css/app.css') }}">
    <link rel="stylesheet" href="{{ \App\Support\Asset::css('css/collections.css') }}">
    <link rel="stylesheet" href="{{ \App\Support\Asset::css('css/follow.css') }}">
    @stack('styles')
</head>
<body>

{{-- ═══ TOAST NOTIFICATION ═══ --}}
<div class="toast-container" id="toastContainer"></div>

{{-- ═══ NAVBAR ═══ --}}
<nav class="navbar" id="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="logo">PARFUM.IN</a>

        <ul class="nav-links">
            <li><a href="{{ route('fragrances.index') }}" class="{{ request()->routeIs('fragrances.*') ? 'active' : '' }}">Fragrances</a></li>
            <li><a href="{{ route('brands.index') }}"     class="{{ request()->routeIs('brands.*')     ? 'active' : '' }}">Brands</a></li>
            <li><a href="{{ route('notes.index') }}"      class="{{ request()->routeIs('notes.*')      ? 'active' : '' }}">Notes</a></li>
            <li><a href="{{ route('accords.index') }}"    class="{{ request()->routeIs('accords.*')    ? 'active' : '' }}">Accords</a></li>
        </ul>

        <div class="nav-right">
            <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                <span class="theme-icon">☀</span>
            </button>

            <div class="nav-search-wrap">
                <div class="nav-search">
                    <input type="text" placeholder="search" class="nav-search-input" id="navSearchInput" autocomplete="off">
                    <button class="nav-search-btn" id="navSearchBtn">⌕</button>
                </div>
                <div class="nav-search-dropdown" id="navSearchDropdown"></div>
            </div>

            <span class="divider">|</span>

            @auth
            {{-- SUDAH LOGIN: tampilkan ikon favorit + avatar --}}

            {{-- Ikon Favorit --}}
            <a href="{{ route('favorites.index') }}" class="nav-fav-btn" title="Favorit saya" id="navFavBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                </svg>
                <span class="nav-fav-count" id="navFavCount"
                    style="{{ Auth::user()->favorites()->count() > 0 ? '' : 'display:none' }}">
                    {{ Auth::user()->favorites()->count() }}
                </span>
            </a>

            {{-- Avatar + Dropdown --}}
            <div class="nav-user-wrap" id="navUserWrap">
                <button class="nav-avatar-btn" id="navAvatarBtn" title="{{ Auth::user()->name }}">
                    @if (Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}"
                         style="width:100%;height:100%;border-radius:50%;object-fit:cover;display:block">
                    @else
                    <span class="nav-avatar-letter">{{ Auth::user()->initial }}</span>
                    @endif
                </button>
                <div class="nav-user-dropdown" id="navUserDropdown">
                    <div class="nav-user-info">
                        <span class="nav-user-name">{{ Auth::user()->name }}</span>
                        <span class="nav-user-email">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="nav-dropdown-divider"></div>
                    <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profil Saya
                    </a>
                    <a href="{{ route('favorites.index') }}" class="nav-dropdown-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                        Favorit Saya
                    </a>
                    <div class="nav-dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-dropdown-item nav-logout-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            @else
            {{-- BELUM LOGIN: tampilkan LOG IN --}}
            <a href="{{ route('login') }}" class="login-link">👤 LOG IN</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══ MODAL: Harus Login ═══ --}}
<div class="modal-overlay" id="loginRequiredModal">
    <div class="modal-box login-required-box">
        <button class="modal-close" id="closeLoginModal">×</button>
        <div class="login-required-icon">🔐</div>
        <h2 class="login-required-title">Login Diperlukan</h2>
        <p class="login-required-desc" id="loginRequiredDesc">
            Anda harus login terlebih dahulu untuk menggunakan fitur ini.
        </p>
        <div class="login-required-actions">
            <a href="{{ route('login') }}" class="auth-btn-primary" style="display:block;text-align:center;padding:11px;text-decoration:none;border-radius:8px;font-size:0.75rem;font-weight:600;background:#111;color:#fff;">
                Login Sekarang
            </a>
            <a href="{{ route('register') }}" class="btn-outline-sm" style="display:block;text-align:center;padding:10px;margin-top:8px;text-decoration:none;border-radius:8px;font-size:0.72rem;">
                Buat Akun Baru
            </a>
        </div>
    </div>
</div>

{{-- ═══ KONTEN ═══ --}}
<main>@yield('content')</main>

<script>
/* ═══════════════════════════════════════════════
   GLOBAL JS
═══════════════════════════════════════════════ */

/* ── Theme ── */
const themeToggle = document.getElementById('themeToggle');
const themeIcon   = themeToggle.querySelector('.theme-icon');
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    themeIcon.textContent = '🌙';
}
themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const dark = document.body.classList.contains('dark-mode');
    themeIcon.textContent = dark ? '🌙' : '☀';
    localStorage.setItem('theme', dark ? 'dark' : 'light');
});

/* ── Navbar hide/show on scroll ── */
const navbar = document.getElementById('navbar');
let lastScroll = 0;
window.addEventListener('scroll', () => {
    const curr = window.scrollY;
    if (curr > lastScroll && curr > 80) navbar.classList.add('hidden');
    else navbar.classList.remove('hidden');
    lastScroll = curr <= 0 ? 0 : curr;
}, { passive: true });

/* ── Avatar dropdown ── */
const avatarBtn = document.getElementById('navAvatarBtn');
const userDropdown = document.getElementById('navUserDropdown');
if (avatarBtn) {
    avatarBtn.addEventListener('click', e => {
        e.stopPropagation();
        userDropdown.classList.toggle('show');
    });
    document.addEventListener('click', () => userDropdown.classList.remove('show'));
}

/* ── Modal Login Required ── */
const loginModal     = document.getElementById('loginRequiredModal');
const closeLoginModal = document.getElementById('closeLoginModal');
if (closeLoginModal) {
    closeLoginModal.addEventListener('click', () => loginModal.classList.remove('show'));
    loginModal.addEventListener('click', e => { if(e.target===loginModal) loginModal.classList.remove('show'); });
}

function showLoginRequired(msg) {
    document.getElementById('loginRequiredDesc').textContent =
        msg || 'Anda harus login terlebih dahulu untuk menggunakan fitur ini.';
    loginModal.classList.add('show');
}

/* ── Toast notification ── */
function showToast(msg, type='success') {
    const tc = document.getElementById('toastContainer');
    const t  = document.createElement('div');
    t.className = `toast toast-${type}`;
    t.textContent = msg;
    tc.appendChild(t);
    setTimeout(() => t.classList.add('show'), 10);
    setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 300); }, 3000);
}

/* ── Update favorit count di navbar ── */
function updateFavCount(count) {
    const badge = document.getElementById('navFavCount');
    if (!badge) return;
    if (count > 0) {
        badge.textContent = count;
        badge.style.display = '';
    } else {
        badge.style.display = 'none';
    }
}

/* ── CSRF helper ── */
function getCsrf() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

/* ── Search Autocomplete ── */
let SEARCH_PRODUCTS = [];
fetch('{{ route("api.search-products") }}')
    .then(r => r.json())
    .then(data => { SEARCH_PRODUCTS = data; })
    .catch(() => {});

const navSearchInput    = document.getElementById('navSearchInput');
const searchDropdown = document.getElementById('navSearchDropdown');
const searchBtn      = document.getElementById('navSearchBtn');

function highlight(text, query) {
    if (!query) return text;
    const idx = text.toLowerCase().indexOf(query.toLowerCase());
    if (idx === -1) return text;
    return text.slice(0, idx) +
        '<span class="search-drop-highlight">' + text.slice(idx, idx + query.length) + '</span>' +
        text.slice(idx + query.length);
}

function renderDropdown(query) {
    const q = query.trim();
    if (!q) { searchDropdown.classList.remove('show'); return; }
    const results = SEARCH_PRODUCTS.filter(p =>
        p.name.toLowerCase().includes(q.toLowerCase()) ||
        p.brand.toLowerCase().includes(q.toLowerCase())
    ).slice(0, 6);
    if (results.length === 0) {
        searchDropdown.innerHTML = '<div class="search-drop-empty">Tidak ada hasil untuk "' + q + '"</div>';
    } else {
        searchDropdown.innerHTML = results.map(p =>
            '<a href="/product/' + p.slug + '" class="search-drop-item">' +
            '<img class="search-drop-img" src="' + p.image + '" alt="' + p.name + '" onerror="this.style.opacity=\'0.2\'">' +
            '<div class="search-drop-info">' +
            '<span class="search-drop-name">' + highlight(p.name, q) + '</span>' +
            '<span class="search-drop-brand">' + highlight(p.brand, q) + '</span>' +
            '</div></a>'
        ).join('');
    }
    searchDropdown.classList.add('show');
}

navSearchInput.addEventListener('input', () => renderDropdown(navSearchInput.value));
navSearchInput.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
        const q = navSearchInput.value.trim();
        if (q) {
            const match = SEARCH_PRODUCTS.find(p => p.name.toLowerCase() === q.toLowerCase());
            if (match) window.location.href = '/product/' + match.slug;
        }
    }
    if (e.key === 'Escape') { searchDropdown.classList.remove('show'); navSearchInput.blur(); }
});
searchBtn.addEventListener('click', () => {
    const q = navSearchInput.value.trim();
    if (q) {
        const match = SEARCH_PRODUCTS.find(p => p.name.toLowerCase() === q.toLowerCase());
        if (match) window.location.href = '/product/' + match.slug;
        else renderDropdown(q);
    } else {
        navSearchInput.focus();
    }
});
document.addEventListener('click', e => {
    if (!e.target.closest('.nav-search-wrap')) searchDropdown.classList.remove('show');
});

@if(session('success'))
showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
showToast("{{ session('error') }}", 'error');
@endif
</script>

@stack('scripts')
</body>
</html>
