@extends('layouts.app')
@section('title', 'Amber — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#7a4010">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Amber</h1>
        <p class="accord-hero-desc">Accord amber yang kaya dan hangat menghadirkan kemewahan dan sensualitas. Resin labdanum, benzoin, dan tonka bean menciptakan aura yang memabukkan dan tak terlupakan.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Amber</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','penthouse') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/penthouse.png') }}" alt="Penthouse" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Penthouse</span>
            <p class="accord-frag-desc">Kemewahan amber yang kaya berpadu dengan oud dan rose untuk wewangian bertanda tangan yang mewah dan penuh prestise.</p>
        </a>
        <a href="{{ route('product.detail','golden-amber') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/golden-amber.png') }}" alt="Golden Amber" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Golden Amber</span>
            <p class="accord-frag-desc">Emas cair yang mengalir di kulit. Amber tua yang kaya dipadukan vanilla Bourbon dan musks yang sensual.</p>
        </a>
        <a href="{{ route('product.detail','resin-smoke') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/resin-smoke.png') }}" alt="Resin Smoke" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Resin Smoke</span>
            <p class="accord-frag-desc">Asap resin yang misterius berpadu dengan labdanum dan incense menciptakan wewangian spiritual yang dalam.</p>
        </a>
        <a href="{{ route('product.detail','amber-nights') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/amber-nights.png') }}" alt="Amber Nights" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Amber Nights</span>
            <p class="accord-frag-desc">Malam yang dipenuhi kehangatan amber, rum, dan tembakau. Wewangian untuk saat-saat istimewa dan penuh kenangan.</p>
        </a>
        <a href="{{ route('product.detail','desert-amber') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/desert-amber.png') }}" alt="Desert Amber" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Desert Amber</span>
            <p class="accord-frag-desc">Kehangatan gurun pasir yang terkandung dalam benzoin, myrrh, dan amber putih yang lembut dan panjang.</p>
        </a>
        <a href="{{ route('product.detail','velvet-gold') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/velvet-gold.png') }}" alt="Velvet Gold" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Velvet Gold</span>
            <p class="accord-frag-desc">Kelembutan beludru emas dengan campuran amber, heliotrope, dan iris untuk aroma feminin yang anggun.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
