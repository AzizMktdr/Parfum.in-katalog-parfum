@extends('layouts.app')
@section('title', 'Dreamscape — Mykonos — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>Mykonos Dreamscape</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">Mykonos</p>
    <h1 class="detail-name-center">Dreamscape</h1>

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
            {{-- 📁 public/images/products/dreamscape.png --}}
            <img src="{{ asset('images/products/dreamscape.png') }}" alt="Dreamscape" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Peony</span><span>Lychee</span><span>Raspberry</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Rose</span><span>Jasmine</span><span>Cyclamen</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>White Musk</span><span>Cedarwood</span><span>Ambrette</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/dreamscape.png') }}" alt="Dreamscape" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Dreamscape</div>
                <div class="detail-purchase-type">Eau De Parfum | 50ml</div>
                <div class="detail-price">Rp130.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">4.8</span>
            <span class="detail-review-count">28 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">Mykonos Dreamscape | for women</p>
        <p class="detail-desc-text">Dreamscape membawa Anda ke taman bunga impian yang penuh keindahan. Perpaduan bunga-bunga segar feminin dengan dry down musk yang hangat menciptakan wewangian yang romantic dan tahan lama sepanjang hari.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'dreamscape',
        'name'  => 'Dreamscape',
        'brand' => 'Mykonos',
        'image' => 'images/products/dreamscape.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'mykonos') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
            <a href="{{ route('product.detail','california-signature') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="California Signature" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">California Signature</span>
                <span class="product-card-brand">Mykonos</span>
            </a>
            <a href="{{ route('product.detail','invade') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/invade.png') }}" alt="Invade" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Invade</span>
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
