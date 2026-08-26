@extends('layouts.app')
@section('title', 'Gili Dreams — Mandalika — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>Mandalika Gili Dreams</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">Mandalika</p>
    <h1 class="detail-name-center">Gili Dreams</h1>

    <div class="detail-main-grid">
        <div class="detail-meta-icons">
            <div class="detail-meta-item">
                <div class="detail-meta-icon">☀</div>
                <span class="detail-meta-label">Day</span>
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon">♀</div>
                <span class="detail-meta-label">Women</span>
            </div>
        </div>

        <div class="detail-image-wrap">
            {{-- 📁 public/images/products/aurora.png --}}
            <img src="{{ asset('images/products/aurora.png') }}" alt="Gili Dreams" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Bergamot</span><span>Coconut</span><span>Lemon</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Tiare</span><span>Jasmine</span><span>Sea Salt</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Vanilla</span><span>Sandalwood</span><span>White Musk</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/aurora.png') }}" alt="Gili Dreams" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Gili Dreams</div>
                <div class="detail-purchase-type">Eau De Parfum | 50ml</div>
                <div class="detail-price">Rp148.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">4.6</span>
            <span class="detail-review-count">25 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">Mandalika Gili Dreams | for women</p>
        <p class="detail-desc-text">Gili Dreams mengabadikan keindahan Gili Islands yang surgawi dalam sebuah wewangian. Tiare flower yang eksotis berpadu dengan aroma laut dan vanilla yang hangat, menciptakan sensasi berjalan di pantai berpasir putih Gili Trawangan.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'gili-dreams',
        'name'  => 'Gili Dreams',
        'brand' => 'Mandalika',
        'image' => 'images/products/aurora.png',
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
            <a href="{{ route('product.detail','rinjani-spirit') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Rinjani Spirit" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Rinjani Spirit</span>
                <span class="product-card-brand">Mandalika</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
