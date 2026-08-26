@extends('layouts.app')
@section('title', 'Fill The Room — Brands — Parfum.in')
@section('content')
<div class="brand-detail-page">
    <div class="brand-detail-top">
        <div class="brand-detail-logo-card" style="background:#1e3a5f">
            <span class="brand-detail-logo-text">FILL THE ROOM</span>
        </div>
        <div class="brand-detail-info">
            <h1 class="brand-detail-name">Fill The Room</h1>
            <p class="brand-detail-est">Est. 2020</p>
            <p class="brand-detail-desc">Dirancang untuk mengisi setiap ruang dengan kehadiran yang berkesan. Setiap botol adalah undangan untuk meninggalkan jejak wangi yang tak terlupakan.</p>
        </div>
    </div>
    <div class="brand-bestseller">
        <h2 class="brand-bestseller-title">Best Seller From Fill The Room</h2>
        <div class="fragrances-grid">
            <a href="{{ route('product.detail','echo') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/echo.png') }}" alt="Echo" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">FILL THE ROOM</span>
                <span class="frag-card-name">Echo</span>
            </a>
            <a href="{{ route('product.detail','resonance') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/resonance.png') }}" alt="Resonance" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">FILL THE ROOM</span>
                <span class="frag-card-name">Resonance</span>
            </a>
            <a href="{{ route('product.detail','ambience') }}" class="frag-card">
                <div class="frag-card-img"><img src="{{ asset('images/products/ambience.png') }}" alt="Ambience" onerror="this.style.opacity='0.1'"></div>
                <span class="frag-card-brand">FILL THE ROOM</span>
                <span class="frag-card-name">Ambience</span>
            </a>
        </div>
    </div>
</div>
@include('partials.footer')
@endsection
