@extends('layouts.app')
@section('title', 'Gourmand — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#5c2a00">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Gourmand</h1>
        <p class="accord-hero-desc">Accord makanan yang manis dan menggoda menghadirkan kelezatan dalam sebuah botol. Vanilla, karamel, dan coklat menciptakan wewangian yang memanjakan indera.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Gourmand</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','vanilla-supreme') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/vanilla-supreme.png') }}" alt="Vanilla Supreme" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Vanilla Supreme</span>
            <p class="accord-frag-desc">Vanilla Bourbon Madagascar yang kaya dan creamy berpadu tonka bean dan benzoin untuk keharuman yang warm dan memanjakan.</p>
        </a>
        <a href="{{ route('product.detail','caramel-dream') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/caramel-dream.png') }}" alt="Caramel Dream" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Caramel Dream</span>
            <p class="accord-frag-desc">Karamel yang mengalir dengan sentuhan sea salt untuk kontras yang sempurna. Manis namun tidak berlebihan dan sangat addictive.</p>
        </a>
        <a href="{{ route('product.detail','chocolate-noir') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/chocolate-noir.png') }}" alt="Chocolate Noir" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Chocolate Noir</span>
            <p class="accord-frag-desc">Dark chocolate 85% yang intense berpadu coffee dan vetiver untuk wewangian gourmand yang sophisticated dan dewasa.</p>
        </a>
        <a href="{{ route('product.detail','praline-rose') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/praline-rose.png') }}" alt="Praline Rose" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Praline Rose</span>
            <p class="accord-frag-desc">Praline almond yang manis berpadu rose dan musks untuk wewangian feminin yang romantic dan menggoda selera.</p>
        </a>
        <a href="{{ route('product.detail','honey-nectar') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/honey-nectar.png') }}" alt="Honey Nectar" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Honey Nectar</span>
            <p class="accord-frag-desc">Madu bunga liar yang golden dan warm dengan chamomile dan vanilla untuk keharuman yang soothing dan menenangkan.</p>
        </a>
        <a href="{{ route('product.detail','marshmallow-sky') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/marshmallow-sky.png') }}" alt="Marshmallow Sky" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Marshmallow Sky</span>
            <p class="accord-frag-desc">Lembut dan manis seperti marshmallow di awan. Heliotrope, benzoin, dan vanilla musks untuk kenyamanan sempurna.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
