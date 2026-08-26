@extends('layouts.app')
@section('title', $brand['name'] . ' — Parfum.in')
@section('content')

<div class="brand-detail-page">

    {{-- Top: Logo card + Deskripsi --}}
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card">
            {{--
            ╔══════════════════════════════════════════╗
            ║  📁 LOGO BRAND:                          ║
            ║     public/images/brands/{slug}.png      ║
            ╚══════════════════════════════════════════╝
            --}}
            <img src="{{ asset('images/brands/' . $brand['slug'] . '.png') }}"
                 alt="{{ $brand['name'] }}"
                 onerror="this.style.opacity='0'">
            <span class="brand-detail-logo-text">{{ strtoupper($brand['name']) }}</span>
        </div>

        <div class="brand-detail-info">
            <h1 class="brand-detail-name">{{ $brand['name'] }}</h1>
            <p class="brand-detail-est">Est. {{ $brand['est'] }}</p>
            <p class="brand-detail-desc">{{ $brand['description'] }}</p>
        </div>
    </div>

    {{-- Best Seller --}}
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From {{ $brand['name'] }}</h2>
        <div class="brand-products-grid">
            @foreach($products as $product)
            <a href="{{ route('product.detail', $product['slug']) }}" class="brand-product-card">
                <div class="brand-product-img">
                    {{--
                    ╔══════════════════════════════════════════╗
                    ║  📁 GAMBAR PRODUK:                       ║
                    ║     public/images/products/{file}        ║
                    ╚══════════════════════════════════════════╝
                    --}}
                    <img src="{{ asset($product['image']) }}"
                         alt="{{ $product['name'] }}"
                         onerror="this.style.opacity='0.1'">
                </div>
                <span class="brand-product-brand">{{ strtoupper($brand['name']) }}</span>
                <span class="brand-product-name">{{ $product['name'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

</div>

@include('partials.footer')
@endsection
