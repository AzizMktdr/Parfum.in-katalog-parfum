@extends('layouts.app')
@section('title', 'Invade — Mykonos — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>Mykonos Invade</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">Mykonos</p>
    <h1 class="detail-name-center">Invade</h1>

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
            {{-- 📁 public/images/products/invade.png --}}
            <img src="{{ asset('images/products/invade.png') }}" alt="Invade" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Black Pepper</span><span>Bergamot</span><span>Lemon</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Iris</span><span>Leather</span><span>Violet Leaf</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Sandalwood</span><span>Vetiver</span><span>Dark Musk</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/invade.png') }}" alt="Invade" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Invade</div>
                <div class="detail-purchase-type">Eau De Parfum | 50ml</div>
                <div class="detail-price">Rp135.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">4.6</span>
            <span class="detail-review-count">31 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">Mykonos Invade | for men</p>
        <p class="detail-desc-text">Invade menghadirkan aroma maskulin yang bold dan penuh karakter. Serangan lada hitam di pembukaan diimbangi iris yang elegan dan leather yang berwibawa, diakhiri sandalwood hangat yang tahan lama sepanjang malam.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'invade',
        'name'  => 'Invade',
        'brand' => 'Mykonos',
        'image' => 'images/products/invade.png',
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
