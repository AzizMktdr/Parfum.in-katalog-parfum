@extends('layouts.app')
@section('title', 'Fruity — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#7a2a10">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Fruity</h1>
        <p class="accord-hero-desc">Aroma buah-buahan segar yang manis dan ceria menghadirkan keceriaan dan energi positif. Dari berry yang juicy hingga tropical fruits yang eksotis.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Fruity</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','berry-crush') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/berry-crush.png') }}" alt="Berry Crush" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Berry Crush</span>
            <p class="accord-frag-desc">Ledakan berry merah yang juicy: raspberry, blackberry, dan strawberry dalam komposisi segar yang penuh vitalitas.</p>
        </a>
        <a href="{{ route('product.detail','tropical-rush') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/tropical-rush.png') }}" alt="Tropical Rush" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Tropical Rush</span>
            <p class="accord-frag-desc">Petualangan tropis dengan mango, passion fruit, dan coconut yang membawa kesegaran pantai tropis ke manapun kamu pergi.</p>
        </a>
        <a href="{{ route('product.detail','peach-nectar') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/peach-nectar.png') }}" alt="Peach Nectar" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Peach Nectar</span>
            <p class="accord-frag-desc">Manis velvet peach yang matang berpadu dengan apricot dan vanilla untuk wewangian gourmand yang memanjakan.</p>
        </a>
        <a href="{{ route('product.detail','apple-crisp') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/apple-crisp.png') }}" alt="Apple Crisp" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Apple Crisp</span>
            <p class="accord-frag-desc">Segar dan renyah seperti apel hijau petik langsung, dengan sentuhan cyclamen dan cedar yang elegan.</p>
        </a>
        <a href="{{ route('product.detail','grape-vine') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/grape-vine.png') }}" alt="Grape Vine" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Grape Vine</span>
            <p class="accord-frag-desc">Anggur musim panen yang manis dan sedikit fermented memberikan karakter unik yang festive dan penuh semangat.</p>
        </a>
        <a href="{{ route('product.detail','fig-tree') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/fig-tree.png') }}" alt="Fig Tree" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Fig Tree</span>
            <p class="accord-frag-desc">Aroma pohon ara yang creamy dan green, dengan fig matang yang manis dan sedikit woody yang sophisticated.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
