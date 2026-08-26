@extends('layouts.app')
@section('title', 'Citrus — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#4a7c20">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Citrus</h1>
        <p class="accord-hero-desc">Citrus hadir sebagai salah satu accord yang paling segar dan populer dalam dunia parfum. Aroma jeruk yang cerah dan enerjik memberikan kesan segar sepanjang hari, menjadikannya pilihan sempurna untuk parfum musim panas dan gaya hidup aktif.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Citrus</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','california-signature') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/california-signature.png') }}" alt="California Signature" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">California Signature</span>
            <p class="accord-frag-desc">Aroma citrus-aquatic yang segar terinspirasi pantai Malibu. Perpaduan bergamot dan jeruk segar yang cerah dan tahan lama.</p>
        </a>
        <a href="{{ route('product.detail','fresh-breeze') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/fresh-breeze.png') }}" alt="Fresh Breeze" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Fresh Breeze</span>
            <p class="accord-frag-desc">Kesegaran angin pagi dengan sentuhan lemon dan jeruk nipis yang membuatmu merasa segar sepanjang hari.</p>
        </a>
        <a href="{{ route('product.detail','citrus-bloom') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/citrus-bloom.png') }}" alt="Citrus Bloom" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Citrus Bloom</span>
            <p class="accord-frag-desc">Perpaduan harmonis bunga citrus dengan base white musk yang lembut dan elegan untuk penggunaan sehari-hari.</p>
        </a>
        <a href="{{ route('product.detail','solar-burst') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/solar-burst.png') }}" alt="Solar Burst" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Solar Burst</span>
            <p class="accord-frag-desc">Ledakan aroma matahari pagi yang dipenuhi yuzu, bergamot, dan jeruk mandarin yang penuh semangat.</p>
        </a>
        <a href="{{ route('product.detail','lime-fizz') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/lime-fizz.png') }}" alt="Lime Fizz" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Lime Fizz</span>
            <p class="accord-frag-desc">Efervesen jeruk nipis yang segar dan ceria, cocok untuk aktivitas outdoor dan petualangan sehari-hari.</p>
        </a>
        <a href="{{ route('product.detail','orange-grove') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/orange-grove.png') }}" alt="Orange Grove" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Orange Grove</span>
            <p class="accord-frag-desc">Berjalan di antara pohon jeruk yang berbuah lebat. Aroma manis-segar yang mengangkat semangat.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
