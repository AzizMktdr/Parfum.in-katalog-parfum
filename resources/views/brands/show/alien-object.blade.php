@extends('layouts.app')
@section('title', 'Alien Object — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#0d2b4e">
            <span class="brand-detail-logo-text">ALIEN OBJECT</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Alien Object</h1>
            <p class="brand-detail-est">Est. 2022</p>
            <p class="brand-detail-desc">Konsep avant-garde dengan aroma yang unik dan berbeda. Alien Object menantang batas konvensional parfum dengan komposisi yang berani dan tidak terduga.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Alien Object</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','void') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/void.png') }}" alt="Void" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ALIEN OBJECT</span>
                <span class="frag-card-name">Void</span>
            </a>
            <a href="{{ route('product.detail','nebula') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/nebula.png') }}" alt="Nebula" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ALIEN OBJECT</span>
                <span class="frag-card-name">Nebula</span>
            </a>
            <a href="{{ route('product.detail','pulsar') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/pulsar.png') }}" alt="Pulsar" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ALIEN OBJECT</span>
                <span class="frag-card-name">Pulsar</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
