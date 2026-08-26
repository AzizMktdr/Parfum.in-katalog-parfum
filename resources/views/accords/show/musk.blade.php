@extends('layouts.app')
@section('title', 'Musk — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#3a3a3a">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Musk</h1>
        <p class="accord-hero-desc">Aroma musk yang lembut dan sensual menjadi fondasi tak terlihat yang membuat wewangian menempel di kulit. Musk modern yang clean dan skin-like.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Musk</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','white-musk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/white-musk.png') }}" alt="White Musk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">White Musk</span>
            <p class="accord-frag-desc">Musk putih yang bersih dan lembut bagaikan baju katun baru. Minimalis namun memorable, cocok dipakai setiap hari.</p>
        </a>
        <a href="{{ route('product.detail','skin-musk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/skin-musk.png') }}" alt="Skin Musk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Skin Musk</span>
            <p class="accord-frag-desc">Musk yang menyatu sempurna dengan kulit menciptakan aroma kedua kulit yang unik dan personal untuk setiap pemakainya.</p>
        </a>
        <a href="{{ route('product.detail','velvet-musk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/velvet-musk.png') }}" alt="Velvet Musk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Velvet Musk</span>
            <p class="accord-frag-desc">Kemewahan musk berbahan beludru dengan sentuhan iris dan sandalwood yang menciptakan aura sensual dan elegan.</p>
        </a>
        <a href="{{ route('product.detail','amber-musk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/amber-musk.png') }}" alt="Amber Musk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Amber Musk</span>
            <p class="accord-frag-desc">Perpaduan musk hangat dan amber yang dalam menciptakan keharuman base yang kuat dan tahan lama seharian penuh.</p>
        </a>
        <a href="{{ route('product.detail','aqua-musk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/aqua-musk.png') }}" alt="Aqua Musk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Aqua Musk</span>
            <p class="accord-frag-desc">Musk berair yang segar dan transparan, ringan di kulit namun meninggalkan jejak wangi yang bersih dan menyenangkan.</p>
        </a>
        <a href="{{ route('product.detail','dark-musk') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/dark-musk.png') }}" alt="Dark Musk" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Dark Musk</span>
            <p class="accord-frag-desc">Musk gelap yang intens dengan sentuhan patchouli dan leather untuk mereka yang ingin tampil bold dan berani.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
