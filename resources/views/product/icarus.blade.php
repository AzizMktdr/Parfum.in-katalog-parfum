@extends('layouts.app')
@section('title', 'Icarus — Velixir — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>Velixir Icarus</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">Velixir</p>
    <h1 class="detail-name-center">Icarus</h1>

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
            <img src="{{ asset('images/products/icarus.png') }}" alt="Icarus" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Extrait De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Bergamot</span><span>Pink Pepper</span><span>Cardamom</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Cedarwood</span><span>Iris</span><span>Violet Leaf</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Amber</span><span>Tonka Bean</span><span>Vanilla</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/icarus.png') }}" alt="Icarus" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Icarus</div>
                <div class="detail-purchase-type">Extrait De Parfum | 50ml</div>
                <div class="detail-price">Rp250.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">4.9</span>
            <span class="detail-review-count">53 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">Velixir Icarus | for men</p>
        <p class="detail-desc-text">Terinspirasi dari mitos Icarus yang berani terbang menuju matahari. Icarus adalah wewangian maskulin yang megah dengan cedarwood kokoh bertemu amber hangat. Komposisi yang anggun dan berkarakter untuk pria modern yang berani.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'icarus',
        'name'  => 'Icarus',
        'brand' => 'Velixir',
        'image' => 'images/products/icarus.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'velixir') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
            <a href="{{ route('product.detail','elixir-noir') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/elixir-noir.png') }}" alt="Elixir Noir" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Elixir Noir</span>
                <span class="product-card-brand">Velixir</span>
            </a>
            <a href="{{ route('product.detail','aurora') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Aurora" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Aurora</span>
                <span class="product-card-brand">Velixir</span>
            </a>
            <a href="{{ route('product.detail','nebula') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="Nebula" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Nebula</span>
                <span class="product-card-brand">Velixir</span>
            </a>
            <a href="{{ route('product.detail','void') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Void" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Void</span>
                <span class="product-card-brand">Velixir</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
