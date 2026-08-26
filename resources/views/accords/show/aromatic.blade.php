@extends('layouts.app')
@section('title', 'Aromatic — Accords — Parfum.in')
@section('content')

<div class="accord-hero" style="background-color:#2d2050">
    <div class="accord-hero-overlay"></div>
    <div class="accord-hero-content">
        <h1 class="accord-hero-title">Aromatic</h1>
        <p class="accord-hero-desc">Kombinasi herbal aromatik yang menyegarkan dan penuh karakter. Lavender, rosemary, dan sage berpadu menciptakan wewangian aromatic-fougere yang classic dan timeless.</p>
    </div>
</div>

<div class="accord-detail-page">
    <h2 class="accord-category-title">Category Aromatic</h2>
    <div class="accord-fragrance-grid">
        <a href="{{ route('product.detail','lavender-field') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/lavender-field.png') }}" alt="Lavender Field" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Lavender Field</span>
            <p class="accord-frag-desc">Ladang lavender Provence yang menenangkan dan indah. Lavender sejati berpadu coumarin dan woody base yang classic.</p>
        </a>
        <a href="{{ route('product.detail','sage-spirit') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/sage-spirit.png') }}" alt="Sage Spirit" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Sage Spirit</span>
            <p class="accord-frag-desc">Sage yang herbal dan slightly smoky menciptakan aroma spiritual dan membumi yang cocok untuk meditasi sehari-hari.</p>
        </a>
        <a href="{{ route('product.detail','rosemary-fresh') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/rosemary-fresh.png') }}" alt="Rosemary Fresh" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Rosemary Fresh</span>
            <p class="accord-frag-desc">Rosemary segar yang aromatic dan slightly medicinal memberikan kesan bersih, herbal, dan penuh vitalitas.</p>
        </a>
        <a href="{{ route('product.detail','basil-mint') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/basil-mint.png') }}" alt="Basil & Mint" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Basil & Mint</span>
            <p class="accord-frag-desc">Basil Italia yang herbal berpadu mint segar dalam komposisi yang lively dan energetic untuk aktivitas sehari-hari.</p>
        </a>
        <a href="{{ route('product.detail','fougere-classic') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/fougere-classic.png') }}" alt="Fougère Classic" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Fougère Classic</span>
            <p class="accord-frag-desc">Fougère klasik yang timeless: lavender, bergamot, coumarin, dan oakmoss dalam komposisi yang telah teruji zaman.</p>
        </a>
        <a href="{{ route('product.detail','aromatic-blend') }}" class="accord-frag-card">
            <div class="accord-frag-img">
                <img src="{{ asset('images/notes/aromatic-blend.png') }}" alt="Aromatic Blend" onerror="this.style.background='#e8e8e8';this.style.opacity='0.5'">
            </div>
            <span class="accord-frag-name">Aromatic Blend</span>
            <p class="accord-frag-desc">Harmoni sempurna dari berbagai herbal pilihan yang menciptakan wewangian aromatic kompleks dan sangat sophisticated.</p>
        </a>
    </div>
</div>

@include('partials.footer')
@endsection
