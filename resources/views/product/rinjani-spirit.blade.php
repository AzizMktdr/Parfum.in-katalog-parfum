@extends('layouts.app')
@section('title', 'Rinjani Spirit — Mandalika — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>Mandalika Rinjani Spirit</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">Mandalika</p>
    <h1 class="detail-name-center">Rinjani Spirit</h1>

    <div class="detail-main-grid">
        <div class="detail-meta-icons">
            <div class="detail-meta-item">
                <div class="detail-meta-icon">🌙</div>
                <span class="detail-meta-label">Night</span>
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon">♂</div>
                <span class="detail-meta-label">Men</span>
            </div>
        </div>

        <div class="detail-image-wrap">
            {{-- 📁 public/images/products/icarus.png --}}
            <img src="{{ asset('images/products/icarus.png') }}" alt="Rinjani Spirit" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Bergamot</span><span>Black Pepper</span><span>Cardamom</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Cedarwood</span><span>Vetiver</span><span>Leather</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Oud</span><span>Sandalwood</span><span>Tonka Bean</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/icarus.png') }}" alt="Rinjani Spirit" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Rinjani Spirit</div>
                <div class="detail-purchase-type">Eau De Parfum | 50ml</div>
                <div class="detail-price">Rp155.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">4.8</span>
            <span class="detail-review-count">18 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">Mandalika Rinjani Spirit | for men</p>
        <p class="detail-desc-text">Rinjani Spirit mengambil inspirasi dari keagungan Gunung Rinjani, salah satu gunung terindah Indonesia. Woody-aromatic yang maskulin dan kuat dengan sentuhan oud Kalimantan menciptakan wewangian yang cocok untuk jiwa petualang.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'rinjani-spirit',
        'name'  => 'Rinjani Spirit',
        'brand' => 'Mandalika',
        'image' => 'images/products/icarus.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'mandalika') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
            <a href="{{ route('product.detail','lombok-breeze') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="Lombok Breeze" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Lombok Breeze</span>
                <span class="product-card-brand">Mandalika</span>
            </a>
            <a href="{{ route('product.detail','kuta-bloom') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/dreamscape.png') }}" alt="Kuta Bloom" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Kuta Bloom</span>
                <span class="product-card-brand">Mandalika</span>
            </a>
            <a href="{{ route('product.detail','senggigi') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/invade.png') }}" alt="Senggigi" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Senggigi</span>
                <span class="product-card-brand">Mandalika</span>
            </a>
            <a href="{{ route('product.detail','gili-dreams') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Gili Dreams" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Gili Dreams</span>
                <span class="product-card-brand">Mandalika</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
