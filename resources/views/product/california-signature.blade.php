@extends('layouts.app')
@section('title', 'California Signature — Mykonos — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>Mykonos California Signature</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">Mykonos</p>
    <h1 class="detail-name-center">California Signature</h1>

    <div class="detail-main-grid">
        <div class="detail-meta-icons">
            <div class="detail-meta-item">
                <div class="detail-meta-icon">🌙☀</div>
                <span class="detail-meta-label">Day & Night</span>
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon">👥</div>
                <span class="detail-meta-label">Unisex</span>
            </div>
        </div>

        <div class="detail-image-wrap">
            {{-- 📁 public/images/products/california-signature.png --}}
            <img src="{{ asset('images/products/california-signature.png') }}" alt="California Signature" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Lavender</span><span>Pear</span><span>Grapefruit</span><span>Pink Salt</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Rhubarb</span><span>Water Blossoms</span><span>Marine Notes</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Moss</span><span>Softened</span><span>Caramel</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/california-signature.png') }}" alt="California Signature" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">California Signature</div>
                <div class="detail-purchase-type">Eau De Parfum | 50ml</div>
                <div class="detail-price">Rp120.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">5.0</span>
            <span class="detail-review-count">47 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">Mykonos California Signature | for women and men</p>
        <p class="detail-desc-text">Mykonos California Signature adalah parfum unisex lokal Indonesia dengan aroma citrus-aquatic yang segar, ceria, dan mewah. Terinspirasi dari suasana pantai Malibu, wewangian ini memiliki ketahanan lama yang tinggi cocok untuk aktivitas sehari-hari sepanjang hari.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'california-signature',
        'name'  => 'California Signature',
        'brand' => 'Mykonos',
        'image' => 'images/products/california-signature.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'mykonos') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
            <a href="{{ route('product.detail','invade') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/invade.png') }}" alt="Invade" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Invade</span>
                <span class="product-card-brand">Mykonos</span>
            </a>
            <a href="{{ route('product.detail','dreamscape') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/dreamscape.png') }}" alt="Dreamscape" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Dreamscape</span>
                <span class="product-card-brand">Mykonos</span>
            </a>
            <a href="{{ route('product.detail','penthouse-myk') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Penthouse" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Penthouse</span>
                <span class="product-card-brand">Mykonos</span>
            </a>
            <a href="{{ route('product.detail','kuta-sunset') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="Kuta Sunset" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Kuta Sunset</span>
                <span class="product-card-brand">Mykonos</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
