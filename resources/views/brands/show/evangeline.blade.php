@extends('layouts.app')
@section('title', 'Evangeline — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#5c1a3a">
            <span class="brand-detail-logo-text">EVANGELINE</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Evangeline</h1>
            <p class="brand-detail-est">Est. 2020</p>
            <p class="brand-detail-desc">Aroma feminin yang lembut dan memukau. Evangeline terinspirasi dari sosok wanita modern yang anggun, kuat, dan penuh pesona.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Evangeline</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','grace') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/grace.png') }}" alt="Grace" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">EVANGELINE</span>
                <span class="frag-card-name">Grace</span>
            </a>
            <a href="{{ route('product.detail','petal') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/petal.png') }}" alt="Petal" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">EVANGELINE</span>
                <span class="frag-card-name">Petal</span>
            </a>
            <a href="{{ route('product.detail','bloom-ev') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/bloom-ev.png') }}" alt="Bloom" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">EVANGELINE</span>
                <span class="frag-card-name">Bloom</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
