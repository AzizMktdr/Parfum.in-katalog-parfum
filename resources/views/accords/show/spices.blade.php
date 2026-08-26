@extends('layouts.app')
@section('title', 'Spices — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#7d1f1f">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Spices</h1>
        <p class="accord-hero-desc">Accord rempah yang hangat dan eksotis menciptakan kedalaman dan misteri pada setiap wewangian. Perpaduan cengkeh, kayu manis, dan lada yang intens membawa kehangatan dan keberanian.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Spices</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','invade') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/invade.png') }}" alt="Invade" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Invade</span>
            <p class="accord-frag-desc">Serangan rempah yang berani dengan campuran lada hitam dan cengkeh yang meledak di kulit. Wewangian untuk jiwa yang pemberani.</p>
        </a>
        <a href="{{ route('product.detail','spice-road') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/spice-road.png') }}" alt="Spice Road" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Spice Road</span>
            <p class="accord-frag-desc">Perjalanan di Jalur Sutra dengan aroma kardamom, kunyit, dan kayu cendana yang eksotis dan berkesan.</p>
        </a>
        <a href="{{ route('product.detail','pepper-noir') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/pepper-noir.png') }}" alt="Pepper Noir" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Pepper Noir</span>
            <p class="accord-frag-desc">Dominasi lada hitam yang tegas dipadukan dengan vetiver dan akar iris yang memberikan karakter maskulin kuat.</p>
        </a>
        <a href="{{ route('product.detail','cinnamon-woods') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/cinnamon-woods.png') }}" alt="Cinnamon Woods" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Cinnamon Woods</span>
            <p class="accord-frag-desc">Kayu manis hangat berpadu dengan sandalwood dan cedar menciptakan kehangatan seperti api unggun di malam dingin.</p>
        </a>
        <a href="{{ route('product.detail','cardamom-dreams') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/cardamom-dreams.png') }}" alt="Cardamom Dreams" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Cardamom Dreams</span>
            <p class="accord-frag-desc">Kardamom yang aromatik berpadu dengan jasmine dan musk putih. Sensasi mimpi yang penuh kehangatan.</p>
        </a>
        <a href="{{ route('product.detail','oriental-spice') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/oriental-spice.png') }}" alt="Oriental Spice" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Oriental Spice</span>
            <p class="accord-frag-desc">Komposisi rempah oriental yang kaya: saffron, oud, dan ambergris yang mewah dan tahan lama seharian.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
