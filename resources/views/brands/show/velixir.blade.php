@extends('layouts.app')
@section('title', 'Velixir — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#2d1b4e">
            <span class="brand-detail-logo-text">VELIXIR</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Velixir</h1>
            <p class="brand-detail-est">Est. 2020</p>
            <p class="brand-detail-desc">Velixir menghadirkan parfum premium dengan formula eksklusif yang menggabungkan bahan-bahan berkualitas tinggi dari seluruh dunia. Setiap botol adalah karya seni yang mengekspresikan kemewahan dan keindahan dalam setiap tetes.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Velixir</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','icarus') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Icarus" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">VELIXIR</span>
                <span class="frag-card-name">Icarus</span>
            </a>
            <a href="{{ route('product.detail','elixir-noir') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/elixir-noir.png') }}" alt="Elixir Noir" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">VELIXIR</span>
                <span class="frag-card-name">Elixir Noir</span>
            </a>
            <a href="{{ route('product.detail','aurora') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/aurora.png') }}" alt="Aurora" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">VELIXIR</span>
                <span class="frag-card-name">Aurora</span>
            </a>
            <a href="{{ route('product.detail','nebula') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/california-signature.png') }}" alt="Nebula" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">VELIXIR</span>
                <span class="frag-card-name">Nebula</span>
            </a>
            <a href="{{ route('product.detail','void') }}" class="frag-card">
                <div class="frag-card-img">
                    <img src="{{ asset('images/products/icarus.png') }}" alt="Void" onerror="this.style.opacity='0.1'">
                </div>
                <span class="frag-card-brand">VELIXIR</span>
                <span class="frag-card-name">Void</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
