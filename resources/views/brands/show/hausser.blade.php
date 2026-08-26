@extends('layouts.app')
@section('title', 'Hausser — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#2c2c2c">
            <span class="brand-detail-logo-text">HAUSSER</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Hausser</h1>
            <p class="brand-detail-est">Est. 2019</p>
            <p class="brand-detail-desc">Parfum mewah dengan sentuhan Eropa yang kuat. Hausser menghadirkan wewangian berkelas dengan inspirasi dari tradisi parfum Prancis dan Jerman.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Hausser</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','berlin') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/berlin.png') }}" alt="Berlin" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">HAUSSER</span>
                <span class="frag-card-name">Berlin</span>
            </a>
            <a href="{{ route('product.detail','wien') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/wien.png') }}" alt="Wien" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">HAUSSER</span>
                <span class="frag-card-name">Wien</span>
            </a>
            <a href="{{ route('product.detail','paris-hausser') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/paris-hausser.png') }}" alt="Paris" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">HAUSSER</span>
                <span class="frag-card-name">Paris</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
