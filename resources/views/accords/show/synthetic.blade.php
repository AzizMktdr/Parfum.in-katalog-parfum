@extends('layouts.app')
@section('title', 'Synthetic — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#1c2c35">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Synthetic</h1>
        <p class="accord-hero-desc">Molekul sintetis modern membuka cakrawala aroma baru yang tidak ada di alam. Dari Iso E Super hingga Ambroxan, accord synthetic menciptakan wewangian futuristik yang unik.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Synthetic</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','molecule-01') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/molecule-01.png') }}" alt="Molecule 01" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Molecule 01</span>
            <p class="accord-frag-desc">Iso E Super murni yang menyatu sempurna dengan skin untuk menciptakan aura invisible namun sangat memorable dan memikat.</p>
        </a>
        <a href="{{ route('product.detail','future-scent') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/future-scent.png') }}" alt="Future Scent" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Future Scent</span>
            <p class="accord-frag-desc">Komposisi modern dengan Ambroxan, Cashmeran, dan Galaxolide yang menciptakan wewangian dari masa depan yang bersih.</p>
        </a>
        <a href="{{ route('product.detail','crystal-air') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/crystal-air.png') }}" alt="Crystal Air" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Crystal Air</span>
            <p class="accord-frag-desc">Transparansi udara kristal melalui Calone dan synthetic musks yang ultra-clean dan sangat wearable setiap hari.</p>
        </a>
        <a href="{{ route('product.detail','neon-pulse') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/neon-pulse.png') }}" alt="Neon Pulse" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Neon Pulse</span>
            <p class="accord-frag-desc">Energi neon yang bergetar: synthetic citrus, ozonic notes, dan musks modern untuk jiwa-jiwa urban yang dinamis.</p>
        </a>
        <a href="{{ route('product.detail','glass-wall') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/glass-wall.png') }}" alt="Glass Wall" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Glass Wall</span>
            <p class="accord-frag-desc">Barrier kaca yang bersih dan minimalis. Synthetic aldehydes dan musks untuk wewangian yang sangat modern.</p>
        </a>
        <a href="{{ route('product.detail','electric-blue') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/electric-blue.png') }}" alt="Electric Blue" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Electric Blue</span>
            <p class="accord-frag-desc">Listrik biru dalam bentuk wewangian: ozone, aquatic synthetics, dan cool musks yang futuristik dan berani.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
