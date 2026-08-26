@extends('layouts.app')
@section('title', $accord['name'] . ' — Accords — Parfum.in')
@section('content')

{{-- Hero banner accord --}}
<div class="accord-hero" style="background-image: url('{{ asset('images/accords/' . $accord['slug'] . '.jpg') }}')">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">{{ $accord['name'] }}</h1>
        <p class="accord-hero-desc">{{ $accord['description'] }}</p>
    </div>
</div>

{{-- Grid fragrance --}}
<div class="accord-detail-page">
    <h2 class="accord-category-title">Category {{ $accord['name'] }}</h2>

    <div class="accord-fragrance-grid">
        @foreach($fragrances as $frag)
        <a href="{{ route('product.detail', $frag['slug']) }}" class="accord-frag-card">
            <div class="accord-frag-img">
                {{--
                ╔══════════════════════════════════════════╗
                ║  📁 GAMBAR NOTE CIRCLE:                  ║
                ║     public/images/notes/{file}           ║
                ╚══════════════════════════════════════════╝
                --}}
                <img src="{{ asset($frag['image']) }}"
                     alt="{{ $frag['name'] }}"
                     onerror="this.src='{{ asset('images/notes/placeholder.png') }}'">
            </div>
            <span class="accord-frag-name">{{ $frag['name'] }}</span>
            <p class="accord-frag-desc">{{ $frag['desc'] }}</p>
        </a>
        @endforeach
    </div>
</div>

@include('partials.footer')
@endsection
