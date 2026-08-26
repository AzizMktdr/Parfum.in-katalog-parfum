@extends('layouts.app')

@section('title', $user->name . ' — Parfum.in')

@section('content')
<div class="profile-page">

    {{-- ── Header Profil (Desain Baru) ── --}}
    <div class="profile-card">

        {{-- Avatar --}}
        <div class="profile-card-avatar">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
            @else
                <span class="profile-avatar-letter">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            @endif
        </div>

        {{-- Info tengah --}}
        <div class="profile-card-info">
            <h1 class="profile-card-name">{{ $user->name }}</h1>
            <span class="profile-card-role">{{ $user->bio_title ?? 'Parfum Enthusiast' }}</span>

            @if($user->bio)
                <p class="profile-card-bio">{{ $user->bio }}</p>
            @endif

        </div>

        {{-- Tombol Edit Profil / Follow --}}
        <div class="profile-card-action">
            @if($isOwner)
                <a href="{{ route('profile.edit') }}" class="btn-profile-edit-pill">Edit Profil</a>
            @elseif(Auth::check())
                <form method="POST" action="{{ route('follow.toggle', $user) }}">
                    @csrf
                    <button type="submit" class="btn-profile-edit-pill {{ $isFollowing ? 'following' : '' }}">
                        {{ $isFollowing ? 'Mengikuti' : 'Follow' }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-profile-edit-pill">Follow</a>
            @endif
        </div>

        {{-- Stat cards kanan: Favorit / Review / Koleksi --}}
        <div class="profile-card-stats">
            <div class="profile-stat-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                <span class="profile-stat-box-num">{{ $stats['favorites'] }}</span>
                <span class="profile-stat-box-label">Favorit</span>
            </div>
            <div class="profile-stat-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span class="profile-stat-box-num">{{ $stats['reviews'] }}</span>
                <span class="profile-stat-box-label">Review</span>
            </div>
            <div class="profile-stat-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span class="profile-stat-box-num">{{ $stats['collections'] }}</span>
                <span class="profile-stat-box-label">Koleksi</span>
            </div>
            <a class="profile-stat-box" href="{{ route('profile.followers', $user->route_handle) }}" style="text-decoration:none;color:inherit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
                <span class="profile-stat-box-num">{{ $stats['followers'] }}</span>
                <span class="profile-stat-box-label">Followers</span>
            </a>
            <a class="profile-stat-box" href="{{ route('profile.following', $user->route_handle) }}" style="text-decoration:none;color:inherit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 11h-6"/></svg>
                <span class="profile-stat-box-num">{{ $stats['following'] }}</span>
                <span class="profile-stat-box-label">Following</span>
            </a>
        </div>

    </div>

    <div class="profile-body">

        {{-- ── Koleksi ── --}}
        @if($collections->count() > 0)
        <section class="profile-section">
            <div class="profile-section-header">
                <h2 class="profile-section-title">Koleksi</h2>
                @auth
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('collections.create') }}" class="btn-new-collection">+ Buat Koleksi</a>
                    @endif
                @endauth
            </div>
            <div class="collections-grid">
                @foreach($collections as $col)
                <a href="{{ route('collections.show', $col) }}" class="collection-card">
                    <div class="collection-card-previews">
                        @forelse($col->previews as $img)
                            <div class="collection-preview-img">
                                <img src="{{ $img }}" alt="">
                            </div>
                        @empty
                            <div class="collection-preview-empty">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                            </div>
                        @endforelse
                    </div>
                    <div class="collection-card-info">
                        <span class="collection-card-name">{{ $col->name }}</span>
                        <div class="collection-card-meta">
                            <span>{{ $col->items_count }} parfum</span>
                            <span>❤️ {{ $col->likes_count }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @else
        <section class="profile-section">
            <div class="profile-section-header">
                <h2 class="profile-section-title">Koleksi</h2>
                @auth
                    @if(Auth::id() === $user->id)
                        <a href="{{ route('collections.create') }}" class="btn-new-collection">+ Buat Koleksi</a>
                    @endif
                @endauth
            </div>
            <p class="profile-empty">Belum ada koleksi publik.</p>
        </section>
        @endif

        {{-- ── Review Terbaru ── --}}
        @if($recentReviews->count() > 0)
        <section class="profile-section">
            <h2 class="profile-section-title">Review Terbaru</h2>
            <div class="profile-reviews-list">
                @foreach($recentReviews as $review)
                <a href="{{ route('product.detail', $review->product_slug) }}" class="profile-review-card">
                    <div class="profile-review-img">
                        @if($review->product?->image_url)
                            <img src="{{ $review->product->image_url }}" alt="">
                        @endif
                    </div>
                    <div class="profile-review-info">
                        <span class="profile-review-name">{{ $review->product?->name ?? $review->product_slug }}</span>
                        @php $avg = round(($review->sillage + $review->projection + $review->longevity) / 3); @endphp
                        <div class="profile-review-stars">
                            @for($i=1;$i<=5;$i++){{ $i <= $avg ? '★' : '☆' }}@endfor
                        </div>
                        <p class="profile-review-text">{{ Str::limit($review->review_text, 80) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>
@endsection


