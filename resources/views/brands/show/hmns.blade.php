@extends('layouts.app')
@section('title', 'HMNS — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#1c1c1c">
            <span class="brand-detail-logo-text">HMNS</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">HMNS</h1>
            <p class="brand-detail-est">Est. 2018</p>
            <p class="brand-detail-desc">HMNS (Humans) adalah brand parfum modern yang terinspirasi dari kompleksitas jiwa manusia. Setiap wewangian dirancang untuk mencerminkan berbagai emosi dan kepribadian yang membentuk diri kita sebagai manusia.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From HMNS</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','orgsm') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/orgsm.png') }}" alt="ORGSM" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">HMNS</span>
                <span class="frag-card-name">ORGSM</span>
            </a>
            <a href="{{ route('product.detail','penthouse') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Penthouse" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">HMNS</span>
                <span class="frag-card-name">Penthouse</span>
            </a>
            <a href="{{ route('product.detail','carbon') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/orgsm.png') }}" alt="Carbon" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">HMNS</span>
                <span class="frag-card-name">Carbon</span>
            </a>
            <a href="{{ route('product.detail','naked') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Naked" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">HMNS</span>
                <span class="frag-card-name">Naked</span>
            </a>
            <a href="{{ route('product.detail','gravity') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/penthouse.png') }}" alt="Gravity" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">HMNS</span>
                <span class="frag-card-name">Gravity</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
