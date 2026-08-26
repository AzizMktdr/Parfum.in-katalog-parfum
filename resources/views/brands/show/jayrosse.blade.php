@extends('layouts.app')
@section('title', 'Jayrosse — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#4a2c0a">
            <span class="brand-detail-logo-text">JAYROSSE</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Jayrosse</h1>
            <p class="brand-detail-est">Est. 2016</p>
            <p class="brand-detail-desc">Brand parfum lokal dengan koleksi elegan yang telah eksis sejak lama. Dikenal dengan kualitas premium dan aroma yang sophisticated untuk pria dan wanita modern.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Jayrosse</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','noir-jayrosse') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/noir-jayrosse.png') }}" alt="Noir" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">JAYROSSE</span>
                <span class="frag-card-name">Noir</span>
            </a>
            <a href="{{ route('product.detail','blanche') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/blanche.png') }}" alt="Blanche" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">JAYROSSE</span>
                <span class="frag-card-name">Blanche</span>
            </a>
            <a href="{{ route('product.detail','rouge-jayrosse') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/rouge-jayrosse.png') }}" alt="Rouge" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">JAYROSSE</span>
                <span class="frag-card-name">Rouge</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
