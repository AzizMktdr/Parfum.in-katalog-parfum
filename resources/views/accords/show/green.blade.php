@extends('layouts.app')
@section('title', 'Green — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#1b4a1e">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Green</h1>
        <p class="accord-hero-desc">Keharuman hijau dari alam menyegarkan pikiran dan jiwa. Aroma daun baru, rumput pagi, dan tanaman herbal yang membawa kita kembali ke pelukan alam.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Green</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','morning-dew') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/morning-dew.png') }}" alt="Morning Dew" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Morning Dew</span>
            <p class="accord-frag-desc">Embun pagi yang segar di atas daun hijau. Aroma violet leaf, galbanum, dan white flowers yang bersih menyegarkan.</p>
        </a>
        <a href="{{ route('product.detail','green-tea') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/green-tea.png') }}" alt="Green Tea" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Green Tea</span>
            <p class="accord-frag-desc">Teh hijau Jepang yang pure dan elegan dengan sentuhan mint dan lemon untuk kesegaran yang menenangkan jiwa.</p>
        </a>
        <a href="{{ route('product.detail','herb-garden') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/herb-garden.png') }}" alt="Herb Garden" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Herb Garden</span>
            <p class="accord-frag-desc">Taman herbal yang subur: rosemary, thyme, dan basil berpadu dalam komposisi aromatic-green yang segar alami.</p>
        </a>
        <a href="{{ route('product.detail','fig-leaf') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/fig-leaf.png') }}" alt="Fig Leaf" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Fig Leaf</span>
            <p class="accord-frag-desc">Daun ara yang green dan slightly creamy memberikan karakter nature yang unik dan modern. Earthy namun segar.</p>
        </a>
        <a href="{{ route('product.detail','bamboo-grove') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/bamboo-grove.png') }}" alt="Bamboo Grove" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Bamboo Grove</span>
            <p class="accord-frag-desc">Rimbunnya kebun bambu Jepang yang segar dan clean, dengan water lily dan white musk yang zen dan menenangkan.</p>
        </a>
        <a href="{{ route('product.detail','forest-walk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/forest-walk.png') }}" alt="Forest Walk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Forest Walk</span>
            <p class="accord-frag-desc">Berjalan di hutan yang hijau dan lembab: fern, pine, dan wet earth berpadu untuk wewangian nature lover sejati.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
