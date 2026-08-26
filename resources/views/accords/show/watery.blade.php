@extends('layouts.app')
@section('title', 'Watery — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#0d3d5e">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Watery</h1>
        <p class="accord-hero-desc">Accord air yang segar dan bersih mengingatkan pada laut, sungai, dan hujan. Wewangian aquatic yang memberikan sensasi kesegaran tanpa batas.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Watery</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','ocean-depth') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/ocean-depth.png') }}" alt="Ocean Depth" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Ocean Depth</span>
            <p class="accord-frag-desc">Kedalaman samudra yang misterius: sea salt, ambrette, dan driftwood menciptakan wewangian aquatic yang maskulin dan kuat.</p>
        </a>
        <a href="{{ route('product.detail','rain-drop') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/rain-drop.png') }}" alt="Rain Drop" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Rain Drop</span>
            <p class="accord-frag-desc">Aroma hujan pertama yang jatuh di bumi kering. Petrichor, violet, dan ozone yang segar dan sangat memorable.</p>
        </a>
        <a href="{{ route('product.detail','sea-glass') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/sea-glass.png') }}" alt="Sea Glass" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Sea Glass</span>
            <p class="accord-frag-desc">Kaca laut yang diasah ombak selama bertahun-tahun. Aroma bersih dan smooth dengan melon, cucumber, dan sea salt.</p>
        </a>
        <a href="{{ route('product.detail','river-stone') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/river-stone.png') }}" alt="River Stone" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">River Stone</span>
            <p class="accord-frag-desc">Batu sungai yang dingin dan bersih. Aquatic notes dengan iris dan woody base yang fresh dan elegan.</p>
        </a>
        <a href="{{ route('product.detail','blue-lagoon') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/blue-lagoon.png') }}" alt="Blue Lagoon" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Blue Lagoon</span>
            <p class="accord-frag-desc">Laguna biru yang jernih di Islandia. Kombinasi arctic air, lotus, dan musks yang dingin dan memikat.</p>
        </a>
        <a href="{{ route('product.detail','mist-valley') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/mist-valley.png') }}" alt="Mist Valley" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Mist Valley</span>
            <p class="accord-frag-desc">Kabut pagi di lembah yang tenang: water notes, lily, dan light woods untuk wewangian yang damai dan menyegarkan.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
