@extends('layouts.app')

@section('title', $collection->name . ' — Parfum.in')

@section('content')
<div class="collection-detail-page">

    {{-- Header --}}
    <div class="collection-detail-header">
        <div class="collection-detail-meta">
            <a href="{{ route('profile.show', $collection->user->username ?? $collection->user->id) }}"
               class="collection-detail-author">
                <div class="collection-author-avatar">
                    @if($collection->user->avatar)
                        <img src="{{ asset('storage/' . $collection->user->avatar) }}" alt="">
                    @else
                        <span>{{ strtoupper(substr($collection->user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <span>{{ $collection->user->name }}</span>
            </a>
            <span class="collection-detail-date">{{ $collection->created_at->format('d M Y') }}</span>
        </div>

        <h1 class="collection-detail-title">{{ $collection->name }}</h1>

        @if($collection->description)
            <p class="collection-detail-desc">{{ $collection->description }}</p>
        @endif

        <div class="collection-detail-actions">
            {{-- Like button --}}
            @auth
            <button class="btn-like-collection {{ $isLiked ? 'liked' : '' }}" id="likeBtn"
                    data-id="{{ $collection->id }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                     stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span id="likeCount">{{ $collection->likes()->count() }}</span>
            </button>
            @endauth

            {{-- Hapus (hanya pemilik) --}}
            @auth
            @if(Auth::id() === $collection->user_id)
            <form method="POST" action="{{ route('collections.destroy', $collection) }}"
                  onsubmit="return confirm('Hapus koleksi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-collection">Hapus</button>
            </form>
            @endif
            @endauth
        </div>
    </div>

    {{-- Grid Produk --}}
    <div class="collection-items-wrap">
        @if($items->count() > 0)
        <div class="product-grid collection-items-grid">
            @foreach($items as $item)
            @if($item->product)
            <a href="{{ route('product.detail', $item->product->slug) }}" class="product-card">
                <div class="product-card-img">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                         onerror="this.style.opacity='0.1'">
                </div>
                <div class="product-card-info">
                    <span class="product-card-name">{{ $item->product->name }}</span>
                    <span class="product-card-brand">{{ $item->product->brand?->name }}</span>
                </div>
            </a>
            @endif
            @endforeach
        </div>
        @else
        <p class="profile-empty">Koleksi ini masih kosong.</p>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
const likeBtn = document.getElementById('likeBtn');
if (likeBtn) {
    likeBtn.addEventListener('click', () => {
        fetch('/collections/{{ $collection->id }}/like', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(d => {
            likeBtn.classList.toggle('liked', d.liked);
            document.getElementById('likeCount').textContent = d.count;
            const heart = likeBtn.querySelector('svg');
            heart.setAttribute('fill', d.liked ? 'currentColor' : 'none');
        });
    });
}
</script>
@endpush
