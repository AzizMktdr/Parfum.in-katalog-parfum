@extends('layouts.app')
@section('title', $accord->name . ' Accord - Parfum.in')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> /
    <a href="{{ route('accords.index') }}">Accords</a> /
    {{ $accord->name }}
</div>

<div style="max-width:1280px;margin:0 auto;padding:40px;">

    <div style="margin-bottom:40px;">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:12px;">
            @if($accord->color)
            <div style="width:48px;height:48px;border-radius:50%;background:{{ $accord->color }};"></div>
            @endif
            <h1 style="font-size:2rem;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;">
                {{ $accord->name }}
            </h1>
        </div>
        @if($accord->description)
        <p style="font-size:0.82rem;color:var(--text-muted);max-width:600px;line-height:1.7;">{{ $accord->description }}</p>
        @endif
    </div>

    <h2 style="font-size:0.7rem;font-weight:800;letter-spacing:0.14em;text-transform:uppercase;margin-bottom:24px;">
        Parfum dengan Accord Ini ({{ $accord->products->count() }})
    </h2>

    @if($accord->products->isNotEmpty())
    <div class="product-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:28px;">
        @foreach($accord->products as $product)
        <a href="{{ route('product.detail', $product->slug) }}" class="product-card" style="text-decoration:none;color:inherit;">
            <div class="product-card-img">
                <img src="{{ $product->image
                        ? (str_starts_with($product->image, 'images/products/') ? asset($product->image) : asset('storage/' . ltrim($product->image, '/')))
                        : asset('images/products/california-signature.png') }}"
                     alt="{{ $product->name }}" onerror="this.style.opacity='0.1'">
            </div>
            <span class="product-card-name">{{ $product->name }}</span>
            <span class="product-card-brand">{{ $product->brand?->name }}</span>
        </a>
        @endforeach
    </div>
    @else
    <p style="color:var(--text-muted);font-size:0.8rem;">Belum ada parfum untuk accord ini.</p>
    @endif

</div>
@endsection
