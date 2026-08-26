@extends('layouts.app')
@section('title', $brand->name . ' — Brands — Parfum.in')

@section('content')

<div class="brand-detail-page">

    {{-- Top: Logo card + Deskripsi (persis seperti gambar referensi) --}}
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background: #1a2b5e;">
            @if($brand->logo)
            <img src="{{ $brand->logo_url }}"
                 alt="{{ $brand->name }}"
                 onerror="this.style.opacity='0'; this.nextElementSibling.style.display='block'">
            @endif
            <span class="brand-detail-logo-text" @if($brand->logo) style="display:none" @endif>{{ strtoupper($brand->name) }}</span>
        </div>

        <div class="brand-detail-info">
            <h1 class="brand-detail-name">{{ $brand->name }}</h1>
            @if($brand->est)
            <p class="brand-detail-est">Est. {{ $brand->est }}</p>
            @elseif($brand->created_at)
            <p class="brand-detail-est">Est. {{ $brand->created_at->format('Y') }}</p>
            @endif
            @if($brand->description)
            <p class="brand-detail-desc">{{ $brand->description }}</p>
            @endif
        </div>
    </div>

    {{-- Best Seller From {Brand} --}}
    @if($brand->products->isNotEmpty())
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From {{ $brand->name }}</h2>
        <div class="brand-products-grid">
            @foreach($brand->products->take(9) as $product)
            <a href="{{ route('product.detail', $product->slug) }}" class="brand-product-card">
                <div class="brand-product-img">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         onerror="this.style.opacity='0.1'">
                </div>
                <span class="brand-product-brand">{{ strtoupper($brand->name) }}</span>
                <span class="brand-product-name">{{ $product->name }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @else
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From {{ $brand->name }}</h2>
        <p style="text-align:center; color:var(--text-muted); font-size:0.75rem; padding: 40px 0;">Belum ada produk untuk brand ini.</p>
    </div>
    @endif

</div>

@include('partials.footer')
@endsection
