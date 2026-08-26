@extends('layouts.app')
@section('title', 'Alchemist — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#3d1f0a">
            <span class="brand-detail-logo-text">ALCHEMIST</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Alchemist</h1>
            <p class="brand-detail-est">Est. 2018</p>
            <p class="brand-detail-desc">Menggabungkan seni dan kimia dalam setiap botol. Alchemist menciptakan formula rahasia yang mengubah bahan-bahan mulia menjadi cairan emas aromatik.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Alchemist</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','aurum') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/aurum.png') }}" alt="Aurum" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ALCHEMIST</span>
                <span class="frag-card-name">Aurum</span>
            </a>
            <a href="{{ route('product.detail','elixir-gold') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/elixir-gold.png') }}" alt="Elixir Gold" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ALCHEMIST</span>
                <span class="frag-card-name">Elixir Gold</span>
            </a>
            <a href="{{ route('product.detail','transmute') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/transmute.png') }}" alt="Transmute" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ALCHEMIST</span>
                <span class="frag-card-name">Transmute</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
