@extends('layouts.app')
@section('title', 'Gravity — HMNS — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>HMNS Gravity</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">HMNS</p>
    <h1 class="detail-name-center">Gravity</h1>

    <div class="detail-main-grid">
        <div class="detail-meta-icons">
            <div class="detail-meta-item">
                <div class="detail-meta-icon">☀</div>
                <span class="detail-meta-label">Day</span>
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon">♂</div>
                <span class="detail-meta-label">Men</span>
            </div>
        </div>

        <div class="detail-image-wrap">
            {{-- 📁 public/images/products/penthouse.png --}}
            <img src="{{ asset('images/products/penthouse.png') }}" alt="Gravity" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Toilette</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Bergamot</span><span>Lavender</span><span>Basil</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Geranium</span><span>Coriander</span><span>Cedarwood</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Oakmoss</span><span>Tonka Bean</span><span>Amber</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/penthouse.png') }}" alt="Gravity" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Gravity</div>
                <div class="detail-purchase-type">Eau De Toilette | 50ml</div>
                <div class="detail-price">Rp155.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★☆</div>
            <span class="detail-rating-score">4.4</span>
            <span class="detail-review-count">52 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">HMNS Gravity | for men</p>
        <p class="detail-desc-text">Gravity HMNS terinspirasi dari gaya hidup aktif pria modern yang dinamis. Fougère segar dengan lavender dan basil yang aromatik, dipadukan cedarwood dan oakmoss yang maskulin dan tahan sepanjang hari.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'gravity',
        'name'  => 'Gravity',
        'brand' => 'HMNS',
        'image' => 'images/products/penthouse.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'hmns') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
            <a href="{{ route('product.detail','orgsm') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/orgsm.png') }}" alt="ORGSM" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">ORGSM</span>
                <span class="product-card-brand">HMNS</span>
            </a>
            <a href="{{ route('product.detail','penthouse') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Penthouse" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Penthouse</span>
                <span class="product-card-brand">HMNS</span>
            </a>
            <a href="{{ route('product.detail','carbon') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/orgsm.png') }}" alt="Carbon" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Carbon</span>
                <span class="product-card-brand">HMNS</span>
            </a>
            <a href="{{ route('product.detail','naked') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Naked" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Naked</span>
                <span class="product-card-brand">HMNS</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
