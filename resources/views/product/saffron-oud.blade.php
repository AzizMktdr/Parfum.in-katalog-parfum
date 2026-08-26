@extends('layouts.app')
@section('title', 'Saffron Oud — SAFF &Co — Parfum.in')
@section('content')

<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    <span>SAFF &Co Saffron Oud</span>
</div>

<div class="detail-page">
    <p class="detail-brand-label">SAFF &Co</p>
    <h1 class="detail-name-center">Saffron Oud</h1>

    <div class="detail-main-grid">
        <div class="detail-meta-icons">
            <div class="detail-meta-item">
                <div class="detail-meta-icon">🌙</div>
                <span class="detail-meta-label">Night</span>
            </div>
            <div class="detail-meta-item">
                <div class="detail-meta-icon">👥</div>
                <span class="detail-meta-label">Unisex</span>
            </div>
        </div>

        <div class="detail-image-wrap">
            {{-- 📁 public/images/products/icarus.png --}}
            <img src="{{ asset('images/products/icarus.png') }}" alt="Saffron Oud" onerror="this.style.opacity='0.15'">
        </div>

        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>
            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">Extrait De Parfum</div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list"><span>Saffron</span><span>Rose</span><span>Bergamot</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list"><span>Oud</span><span>Incense</span><span>Labdanum</span></div>
            </div>
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list"><span>Ambergris</span><span>Sandalwood</span><span>Benzoin</span></div>
            </div>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                <img src="{{ asset('images/products/icarus.png') }}" alt="Saffron Oud" onerror="this.style.opacity='0'">
            </div>
            <div>
                <div class="detail-purchase-name">Saffron Oud</div>
                <div class="detail-purchase-type">Extrait De Parfum | 30ml</div>
                <div class="detail-price">Rp320.000</div>
            </div>
        </div>
        <div class="detail-purchase-right">
            <div class="detail-stars">★★★★★</div>
            <span class="detail-rating-score">5.0</span>
            <span class="detail-review-count">16 review</span>
        </div>
    </div>

    <hr class="detail-divider">

    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">SAFF &Co Saffron Oud | for women and men</p>
        <p class="detail-desc-text">Saffron Oud adalah mahkota koleksi SAFF & Co. Menggunakan saffron Iran grade premium dan oud Kalimantan asli, wewangian ini adalah perjalanan aromaterapi mewah yang menggabungkan tradisi Timur Tengah dan kekayaan Nusantara.</p>
    </div>

    <hr class="detail-divider">

    {{-- Favorit + Review (dari DB) --}}
    @include('partials.product-actions', [
        'slug'  => 'saffron-oud',
        'name'  => 'Saffron Oud',
        'brand' => 'SAFF &Co',
        'image' => 'images/products/icarus.png',
    ])

    <hr class="detail-divider">

    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            <a href="{{ route('brands.show', 'saff-co') }}" class="see-more">See more ›</a>
        </div>
        <div class="product-grid">
            <a href="{{ route('product.detail','amber-musk') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/dreamscape.png') }}" alt="Amber Musk" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Amber Musk</span>
                <span class="product-card-brand">SAFF &Co</span>
            </a>
            <a href="{{ route('product.detail','rose-taif') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Rose Taif" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Rose Taif</span>
                <span class="product-card-brand">SAFF &Co</span>
            </a>
            <a href="{{ route('product.detail','nusantara-wood') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Nusantara Wood" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Nusantara Wood</span>
                <span class="product-card-brand">SAFF &Co</span>
            </a>
            <a href="{{ route('product.detail','spice-market') }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Spice Market" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">Spice Market</span>
                <span class="product-card-brand">SAFF &Co</span>
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
