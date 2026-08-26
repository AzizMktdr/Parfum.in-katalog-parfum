@extends('layouts.app')
@section('title', 'Mykonos — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#1a2b5e">
            <span class="brand-detail-logo-text">MYKONOS</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Mykonos</h1>
            <p class="brand-detail-est">Est. 2019</p>
            <p class="brand-detail-desc">Mykonos adalah brand parfum lokal Indonesia yang viral karena aromanya memiliki ketahanan lama (setingkat konsentrasi Extrait de Parfum), dan kemasan mewah. Terinspirasi dari keindahan Yunani, wewangiannya bervariasi mulai dari manis fruity, floral elegan, creamy, hingga woody yang hangat, cocok untuk pria dan wanita.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Mykonos</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','california-signature') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="California Signature" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MYKONOS</span>
                <span class="frag-card-name">California Signature</span>
            </a>
            <a href="{{ route('product.detail','invade') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/invade.png') }}" alt="Invade" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MYKONOS</span>
                <span class="frag-card-name">Invade</span>
            </a>
            <a href="{{ route('product.detail','dreamscape') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/dreamscape.png') }}" alt="Dreamscape" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MYKONOS</span>
                <span class="frag-card-name">Dreamscape</span>
            </a>
            <a href="{{ route('product.detail','penthouse-myk') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Penthouse" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MYKONOS</span>
                <span class="frag-card-name">Penthouse</span>
            </a>
            <a href="{{ route('product.detail','kuta-sunset') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="Kuta Sunset" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">MYKONOS</span>
                <span class="frag-card-name">Kuta Sunset</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
