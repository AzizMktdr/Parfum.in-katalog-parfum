@extends('layouts.app')
@section('title', 'Octarine — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#1a4a3a">
            <span class="brand-detail-logo-text">OCTARINE</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Octarine</h1>
            <p class="brand-detail-est">Est. 2023</p>
            <p class="brand-detail-desc">Brand terbaru dengan inovasi aroma kontemporer. Octarine mengeksplorasi batas antara dunia nyata dan imajinasi melalui komposisi parfum yang visioner.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Octarine</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','prism') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/prism.png') }}" alt="Prism" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">OCTARINE</span>
                <span class="frag-card-name">Prism</span>
            </a>
            <a href="{{ route('product.detail','spectrum') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/spectrum.png') }}" alt="Spectrum" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">OCTARINE</span>
                <span class="frag-card-name">Spectrum</span>
            </a>
            <a href="{{ route('product.detail','refract') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/refract.png') }}" alt="Refract" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">OCTARINE</span>
                <span class="frag-card-name">Refract</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
