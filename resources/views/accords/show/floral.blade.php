@extends('layouts.app')
@section('title', 'Floral — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#7a1a4a">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Floral</h1>
        <p class="accord-hero-desc">Keharuman bunga yang indah dan feminin menghadirkan taman bunga terbaik dunia ke dalam sebuah botol. Dari rose yang romantis hingga jasmine yang intoksikasi.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Floral</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','dreamscape') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/dreamscape.png') }}" alt="Dreamscape" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Dreamscape</span>
            <p class="accord-frag-desc">Taman bunga dalam mimpi: peony, rose, dan lily yang lembut berpadu dengan musk putih yang anggun dan feminin.</p>
        </a>
        <a href="{{ route('product.detail','rose-absolute') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/rose-absolute.png') }}" alt="Rose Absolute" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Rose Absolute</span>
            <p class="accord-frag-desc">Rose Bulgaria yang murni dan berharga dipadukan dengan oud dan sandalwood untuk keharum yang timeless dan mewah.</p>
        </a>
        <a href="{{ route('product.detail','jasmine-nights') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/jasmine-nights.png') }}" alt="Jasmine Nights" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Jasmine Nights</span>
            <p class="accord-frag-desc">Jasmine sambac yang intens dan memabukkan di malam hari, berpadu dengan neroli dan musks untuk femininitas penuh.</p>
        </a>
        <a href="{{ route('product.detail','lily-white') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/lily-white.png') }}" alt="Lily White" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Lily White</span>
            <p class="accord-frag-desc">Lily of the valley yang bersih dan segar menciptakan kesan kemurnian dan elegansi yang tak lekang oleh waktu.</p>
        </a>
        <a href="{{ route('product.detail','peony-blush') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/peony-blush.png') }}" alt="Peony Blush" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Peony Blush</span>
            <p class="accord-frag-desc">Peony pink yang romantis berpadu dengan lychee dan raspberry untuk wewangian segar dan girly yang menawan.</p>
        </a>
        <a href="{{ route('product.detail','magnolia-kiss') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/magnolia-kiss.png') }}" alt="Magnolia Kiss" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Magnolia Kiss</span>
            <p class="accord-frag-desc">Magnolia yang manis dan berbunga berpadu dengan musks hangat untuk keharuman yang lembut dan memikat.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
