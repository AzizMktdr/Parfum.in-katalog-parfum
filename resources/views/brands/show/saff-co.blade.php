@extends('layouts.app')
@section('title', 'SAFF &Co — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#8B6914">
            <span class="brand-detail-logo-text">SAFF &CO</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">SAFF &Co</h1>
            <p class="brand-detail-est">Est. 2017</p>
            <p class="brand-detail-desc">SAFF & Co adalah brand parfum artisan premium yang menggunakan bahan-bahan alami pilihan berkualitas tertinggi dari Nusantara dan dunia. Menggabungkan tradisi parfum Orient dengan modernitas untuk menciptakan wewangian yang kaya dan autentik.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From SAFF &Co</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','saffron-oud') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Saffron Oud" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">SAFF &CO</span>
                <span class="frag-card-name">Saffron Oud</span>
            </a>
            <a href="{{ route('product.detail','amber-musk') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/dreamscape.png') }}" alt="Amber Musk" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">SAFF &CO</span>
                <span class="frag-card-name">Amber Musk</span>
            </a>
            <a href="{{ route('product.detail','rose-taif') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Rose Taif" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">SAFF &CO</span>
                <span class="frag-card-name">Rose Taif</span>
            </a>
            <a href="{{ route('product.detail','nusantara-wood') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Nusantara Wood" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">SAFF &CO</span>
                <span class="frag-card-name">Nusantara Wood</span>
            </a>
            <a href="{{ route('product.detail','spice-market') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Spice Market" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">SAFF &CO</span>
                <span class="frag-card-name">Spice Market</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
