@extends('layouts.app')
@section('title', 'Mandalika — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#1a5e3a">
            <span class="brand-detail-logo-text">MANDALIKA</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Mandalika</h1>
            <p class="brand-detail-est">Est. 2021</p>
            <p class="brand-detail-desc">Terinspirasi dari keindahan alam Lombok dan Mandalika yang menakjubkan, brand ini menghadirkan aroma tropis yang segar dan eksotis. Setiap wewangian adalah penghormatan untuk pesona pulau-pulau indah Indonesia Timur.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Mandalika</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','lombok-breeze') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="Lombok Breeze" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MANDALIKA</span>
                <span class="frag-card-name">Lombok Breeze</span>
            </a>
            <a href="{{ route('product.detail','kuta-bloom') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/dreamscape.png') }}" alt="Kuta Bloom" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MANDALIKA</span>
                <span class="frag-card-name">Kuta Bloom</span>
            </a>
            <a href="{{ route('product.detail','senggigi') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/invade.png') }}" alt="Senggigi" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MANDALIKA</span>
                <span class="frag-card-name">Senggigi</span>
            </a>
            <a href="{{ route('product.detail','rinjani-spirit') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Rinjani Spirit" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MANDALIKA</span>
                <span class="frag-card-name">Rinjani Spirit</span>
            </a>
            <a href="{{ route('product.detail','gili-dreams') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Gili Dreams" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MANDALIKA</span>
                <span class="frag-card-name">Gili Dreams</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
