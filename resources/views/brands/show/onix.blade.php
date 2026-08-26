@extends('layouts.app')
@section('title', 'Onix — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#1a1a2e">
            <span class="brand-detail-logo-text">ONIX</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Onix</h1>
            <p class="brand-detail-est">Est. 2021</p>
            <p class="brand-detail-desc">Parfum bold dengan karakter kuat dan maskulin. Onix menghadirkan wewangian gelap dan intens yang cocok untuk mereka yang ingin tampil berkesan.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Onix</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','obsidian') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/obsidian.png') }}" alt="Obsidian" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ONIX</span>
                <span class="frag-card-name">Obsidian</span>
            </a>
            <a href="{{ route('product.detail','midnight-onix') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/midnight-onix.png') }}" alt="Midnight" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ONIX</span>
                <span class="frag-card-name">Midnight</span>
            </a>
            <a href="{{ route('product.detail','shadow') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/shadow.png') }}" alt="Shadow" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">ONIX</span>
                <span class="frag-card-name">Shadow</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
