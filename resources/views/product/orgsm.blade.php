@extends('layouts.app')
@section('title', 'ORGSM — HMNS — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>HMNS ORGSM</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">HMNS</p>
    <h1 class="detail-name-center">ORGSM</h1>

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
            {{-- 📁 public/images/products/orgsm.png --}}
            <img src="{{ asset('images/products/orgsm.png') }}" alt="ORGSM" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Eau De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Bergamot</span><span>Neroli</span><span>Mandarin</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Jasmine</span><span>Ylang Ylang</span><span>Tuberose</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Sandalwood</span><span>Musk</span><span>Vanilla</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/orgsm.png') }}" alt="ORGSM" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">ORGSM</div>
                <div class="detail-purchase-type">Eau De Parfum | 50ml</div>
                <div class="detail-price">Rp185.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">4.7</span>
            <span class="detail-review-count">61 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">HMNS ORGSM | for women and men</p>
        <p class="detail-desc-text">ORGSM adalah wewangian yang intens, sensual, dan memabukkan. Komposisi floral-oriental yang kompleks dan berani dengan jasmine dan tuberose di jantung, diakhiri sandalwood dan vanilla yang hangat dan panjang.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'orgsm',
        'name'  => 'ORGSM',
        'brand' => 'HMNS',
        'image' => 'images/products/orgsm.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'hmns') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
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
            <a href="{{ route('product.detail','gravity') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Gravity" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Gravity</span>
                <span class="product-card-brand">HMNS</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
