@extends('layouts.app')
@section('title', 'Wood — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#3d2b1f">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Wood</h1>
        <p class="accord-hero-desc">Aroma kayu yang maskulin dan elegan menghadirkan koneksi mendalam dengan alam. Dari sandalwood yang hangat hingga cedarwood yang segar, accord wood memberikan ketenangan dan keanggunan.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Wood</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','icarus') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/icarus.png') }}" alt="Icarus" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Icarus</span>
            <p class="accord-frag-desc">Cedarwood yang megah bertemu amber dan vanilla dalam perpaduan yang anggun dan tahan lama, terinspirasi dari mitos Icarus.</p>
        </a>
        <a href="{{ route('product.detail','cedar-stone') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/cedar-stone.png') }}" alt="Cedar Stone" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Cedar Stone</span>
            <p class="accord-frag-desc">Kekokohan batu bertemu kehangatan cedar. Wewangian maskulin yang solid dan dapat diandalkan untuk setiap kesempatan.</p>
        </a>
        <a href="{{ route('product.detail','sandalwood-dream') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/sandalwood-dream.png') }}" alt="Sandalwood Dream" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Sandalwood Dream</span>
            <p class="accord-frag-desc">Kemewahan sandalwood Mysore yang creamy berpadu dengan rose dan musk untuk wewangian unisex yang memukau.</p>
        </a>
        <a href="{{ route('product.detail','oud-mystique') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/oud-mystique.png') }}" alt="Oud Mystique" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Oud Mystique</span>
            <p class="accord-frag-desc">Oud Arab yang berharga dipadukan dengan resin labdanum dan patchouli untuk keharuman yang mewah dan kompleks.</p>
        </a>
        <a href="{{ route('product.detail','vetiver-earth') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/vetiver-earth.png') }}" alt="Vetiver Earth" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Vetiver Earth</span>
            <p class="accord-frag-desc">Akar vetiver yang earthy dan smoky memberikan karakter unik yang menyatu dengan kulit secara sempurna.</p>
        </a>
        <a href="{{ route('product.detail','dark-forest') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/dark-forest.png') }}" alt="Dark Forest" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Dark Forest</span>
            <p class="accord-frag-desc">Menembus hutan gelap yang dipenuhi pine, moss, dan oakmoss dengan sentuhan leather yang maskulin dan intens.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
