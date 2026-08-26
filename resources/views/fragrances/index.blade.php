@extends('layouts.app')
@section('title', 'Fragrances — Parfum.in')
@section('content')

<div class="fragrances-page">
    <h1 class="fragrances-title">Fragrances</h1>

    {{-- Search bar --}}
    <div class="fragrances-search-bar">
        <button class="frag-filter-btn active" id="fragFilterAll">All</button>
        <input type="text" placeholder="search..." class="frag-search-input" id="fragSearch">
        <button class="frag-search-icon">⌕</button>
    </div>

    {{-- Tampilkan per brand, 5 produk per brand --}}
    @foreach($byBrand as $brandName => $items)
    <div class="frag-brand-group" data-brand="{{ $brandName }}">
        <div class="frag-brand-header">
            <h2 class="frag-brand-title">{{ $brandName }}</h2>
            @php $firstItem = $items[0] ?? null; @endphp
            @if($firstItem && !empty($firstItem['brand_slug']))
            <a href="{{ route('brands.show', $firstItem['brand_slug']) }}" class="see-more">See more ›</a>
            @else
            <a href="{{ route('brands.show', \Illuminate\Support\Str::slug($brandName)) }}" class="see-more">See more ›</a>
            @endif
        </div>
        <div class="fragrances-grid" id="fragGrid-{{ Str::slug($brandName) }}">
            @foreach($items as $frag)
            <a href="{{ route('product.detail', $frag['slug']) }}"
               class="frag-card"
               data-name="{{ strtolower($frag['name']) }}"
               data-brand="{{ strtolower($brandName) }}">
                <div class="frag-card-img">
                    {{--
                    ╔══════════════════════════════════════╗
                    ║  📁 public/{{ $frag['image'] }}      ║
                    ╚══════════════════════════════════════╝
                    --}}
                    <img src="{{ asset($frag['image']) }}"
                         alt="{{ $frag['name'] }}"
                         onerror="this.style.opacity='0.15'">
                </div>
                <span class="frag-card-name">{{ $frag['name'] }}</span>
                <span class="frag-card-brand">{{ $frag['brand'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endforeach

    <div style="text-align:center; padding: 20px 0 40px;">
        <a href="#" class="see-all-link">See All</a>
    </div>
</div>

@include('partials.footer')
@endsection

@push('scripts')
<script>
const fragSearch  = document.getElementById('fragSearch');
const fragFilterAll = document.getElementById('fragFilterAll');
const allCards    = document.querySelectorAll('.frag-card');

fragSearch.addEventListener('input', () => {
    const q = fragSearch.value.toLowerCase().trim();
    allCards.forEach(card => {
        const match = card.dataset.name.includes(q) || card.dataset.brand.includes(q);
        card.style.display = (!q || match) ? '' : 'none';
    });
    // Sembunyikan grup jika semua produknya tersembunyi
    document.querySelectorAll('.frag-brand-group').forEach(group => {
        const visible = [...group.querySelectorAll('.frag-card')].some(c => c.style.display !== 'none');
        group.style.display = visible ? '' : 'none';
    });
});
</script>
@endpush
