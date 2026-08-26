@extends('layouts.app')
@section('title', $product->name . ' — ' . ($product->brand?->name ?? '') . ' — Parfum.in')

@section('content')

{{-- Breadcrumb --}}
<div class="detail-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('fragrances.index') }}">Fragrances</a>
    <span>›</span>
    @if($product->brand)
    <a href="{{ route('brands.show', $product->brand->slug) }}">{{ $product->brand->name }}</a>
    <span>›</span>
    @endif
    <span>{{ $product->name }}</span>
</div>

<div class="detail-page">

    {{-- Brand label + Name --}}
    <p class="detail-brand-label">{{ $product->brand?->name ?? '' }}</p>
    <h1 class="detail-name-center">{{ $product->name }}</h1>

    {{-- Main 3-col grid: meta icons | image | product details --}}
    <div class="detail-main-grid">

        {{-- Left: meta icons --}}
        <div class="detail-meta-icons">
            @php
                $collection = $product->collection;
                $gender     = $product->gender ?? 'for women and men';
            @endphp

            @if($collection === 'night')
            <div class="detail-meta-item">
                <div class="detail-meta-icon">🌙</div>
                <span class="detail-meta-label">Night</span>
            </div>
            @elseif($collection === 'day')
            <div class="detail-meta-item">
                <div class="detail-meta-icon">☀</div>
                <span class="detail-meta-label">Day</span>
            </div>
            @else
            <div class="detail-meta-item">
                <div class="detail-meta-icon">☀🌙</div>
                <span class="detail-meta-label">Day & Night</span>
            </div>
            @endif

            <div class="detail-meta-item">
                @if(str_contains(strtolower($gender), 'men') && str_contains(strtolower($gender), 'women'))
                    <div class="detail-meta-icon">👫</div>
                    <span class="detail-meta-label">Unisex</span>
                @elseif(str_contains(strtolower($gender), 'men'=))
                    <div class="detail-meta-icon">👔</div>
                    <span class="detail-meta-label">For Men</span>
                @else
                    <div class="detail-meta-icon">👗</div>
                    <span class="detail-meta-label">For Women</span>
                @endif
            </div>
        </div>

        {{-- Center: product image --}}
        <div class="detail-image-wrap">
            @if($product->image)
            @php
                $imgUrl = str_starts_with($product->image, 'images/')
                    ? asset($product->image)
                    : asset('storage/' . ltrim($product->image, '/'));
            @endphp
            <img fetchpriority="high" src="{{ $imgUrl }}" alt="{{ $product->name }}" onerror="this.style.display='none'">
            @endif
        </div>

        {{-- Right: Product Details --}}
        <div class="detail-info">
            <div class="detail-info-title">Product Details</div>

            <div class="detail-info-row">
                <div class="detail-info-label">Type</div>
                <div class="detail-info-value">{{ $product->category ?? 'Eau De Parfum' }}</div>
            </div>

            @if($product->volume_ml)
            <div class="detail-info-row">
                <div class="detail-info-label">Size</div>
                <div class="detail-info-value">{{ $product->volume_ml }}ml</div>
            </div>
            @endif

            @if($product->topNotes->isNotEmpty())
            <div class="detail-info-row">
                <div class="detail-info-label">Top Notes</div>
                <div class="detail-notes-list">
                    @foreach($product->topNotes as $note)
                    <span>{{ $note->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($product->middleNotes->isNotEmpty())
            <div class="detail-info-row">
                <div class="detail-info-label">Middle Notes</div>
                <div class="detail-notes-list">
                    @foreach($product->middleNotes as $note)
                    <span>{{ $note->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($product->baseNotes->isNotEmpty())
            <div class="detail-info-row">
                <div class="detail-info-label">Base Notes</div>
                <div class="detail-notes-list">
                    @foreach($product->baseNotes as $note)
                    <span>{{ $note->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($product->accords->isNotEmpty())
            <div class="detail-info-row">
                <div class="detail-info-label">Accords</div>
                <div class="detail-accords-list">
                    @foreach($product->accords as $accord)
                    <span class="detail-accord-tag" style="background: {{ $accord->color ?? '#e8e8e8' }}20; border: 1px solid {{ $accord->color ?? '#999' }}40; color: {{ $accord->color ?? 'var(--text-muted)' }}">{{ $accord->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <hr class="detail-divider">

    {{-- Purchase row: thumbnail + name + price + rating --}}
    <div class="detail-purchase-row">
        <div class="detail-purchase-left">
            <div class="detail-thumb">
                @if($product->image)
                @php
                    $imgUrl = str_starts_with($product->image, 'images/')
                        ? asset($product->image)
                        : asset('storage/' . ltrim($product->image, '/'));
                @endphp
                <img loading="lazy" src="{{ $imgUrl }}" alt="{{ $product->name }}" onerror="this.style.display='none'">
                @endif
            </div>
            <div>
                <div class="detail-purchase-name">{{ $product->name }}</div>
                <div class="detail-purchase-type">{{ $product->category ?? 'EDP' }} | {{ $product->volume_ml ? $product->volume_ml.'ml' : '—' }}</div>
                @if($product->price)
                <div class="detail-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                @endif
            </div>
        </div>
        <div class="detail-purchase-right">
            @php
                $reviews = $product->reviews;
                $avgRating = $reviews->isNotEmpty()
                    ? round($reviews->avg(fn($r) => ($r->sillage + $r->projection + $r->longevity) / 3), 1)
                    : 0;
                $reviewCount = $reviews->count();
            @endphp
            <div class="detail-stars">
                @for($i=1; $i<=5; $i++)
                    {{ $i <= floor($avgRating) ? '★' : '☆' }}
                @endfor
            </div>
            <span class="detail-rating-score">{{ $avgRating > 0 ? $avgRating : '—' }}</span>
            <span class="detail-review-count">{{ $reviewCount }} review</span>

            {{-- Favorite button --}}
            @auth
            <button class="detail-fav-btn" id="favBtn" data-slug="{{ $product->slug }}" title="Tambah ke Favorit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                </svg>
            </button>
            @endauth
        </div>
    </div>

    <hr class="detail-divider">

    {{-- Description --}}
    <div class="detail-desc-section">
        <div class="detail-desc-title">Description</div>
        <p class="detail-desc-subtitle">{{ $product->brand?->name ?? '' }} {{ $product->name }} | {{ ucwords($product->gender ?? 'for women and men') }}</p>
        <p class="detail-desc-text">{{ $product->description ?? 'Belum ada deskripsi untuk parfum ini.' }}</p>
    </div>

    <hr class="detail-divider">

    {{-- Reviews --}}
    <div class="detail-reviews-section">
        <div class="detail-reviews-title">Review by Users</div>

        {{-- ✅ pakai relasi yang SUDAH di-eager load di controller (tanpa query baru per render) --}}
        @forelse($reviews->take(5) as $review)
        <div class="review-card">
            <div class="review-header">
                <span class="review-author">{{ $review->user?->name ?? 'Anonymous' }}</span>
                <span class="review-date">{{ $review->created_at->format('d F Y') }}</span>
            </div>
            <div class="review-stars">
                @php $ratingAvg = round(($review->sillage + $review->projection + $review->longevity) / 3); @endphp
                @for($i=1; $i<=5; $i++){{ $i <= $ratingAvg ? '★' : '☆' }}@endfor
            </div>
            <div class="review-tags">
                <span class="review-tag">Sillage: <strong>{{ $review->sillage }}/5</strong></span>
                <span class="review-tag">Projection: <strong>{{ $review->projection }}/5</strong></span>
                <span class="review-tag">Longevity: <strong>{{ $review->longevity }}/5</strong></span>
            </div>
            <p class="review-text">{{ $review->review_text }}</p>
        </div>
        @empty
        <p style="font-size:0.72rem; color:var(--text-muted); padding: 16px 0;">Belum ada review. Jadilah yang pertama!</p>
        @endforelse

        <div class="review-actions">
            <a href="{{ route('reviews.index', $product->slug) }}" class="btn-outline-sm">See all reviews</a>
            @auth
            <button class="btn-outline-sm btn-write-review" id="openReviewModal">Write a Review</button>
            @else
            <button class="btn-outline-sm" onclick="showLoginRequired('Login untuk menulis review.')">Write a Review</button>
            @endauth
        </div>
    </div>

    <hr class="detail-divider">

    {{-- From the same brand --}}
    <div class="from-brand-section">
        <div class="from-brand-header">
            <span class="from-brand-title">From the same brand</span>
            @if($product->brand)
            <a href="{{ route('brands.show', $product->brand->slug) }}" class="see-more">See more ›</a>
            @endif
        </div>
        @if(isset($related) && $related->isNotEmpty())
        <div class="product-grid">
            @foreach($related as $item)
            <a href="{{ route('product.detail', $item['slug']) }}" class="product-card">
                <div class="product-card-img">
                    @if(!empty($item['image']))
                    <img loading="lazy" src="{{ str_starts_with($item['image'], 'images/') ? asset($item['image']) : asset('storage/' . ltrim($item['image'], '/')) }}"
                         alt="{{ $item['name'] }}"
                         onerror="this.style.display='none'">
                    @endif
                </div>
                <span class="product-card-name">{{ $item['name'] }}</span>
                <span class="product-card-brand">{{ $item['brand'] }}</span>
            </a>
            @endforeach
        </div>
        @else
        <p style="font-size:0.72rem; color:var(--text-muted);">Tidak ada produk lain dari brand ini.</p>
        @endif
    </div>

</div>{{-- end detail-page --}}

@include('partials.footer')

{{-- Modal: Write a Review --}}
@auth
<div class="modal-overlay" id="reviewModalOverlay">
    <div class="modal-box review-modal">
        <button class="modal-close" id="closeReviewModal">×</button>
        <h2 class="modal-title">Share Your Experience</h2>
        <form method="POST" action="{{ route('review.store', $product->slug) }}" id="reviewForm">
            @csrf
            <div class="review-modal-ratings">
                @foreach(['sillage' => 'Sillage', 'projection' => 'Projection', 'longevity' => 'Longevity'] as $field => $label)
                <div class="review-rating-group">
                    <span class="review-rating-label">{{ $label }}</span>
                    <div class="star-rating" data-name="{{ $field }}">
                        @for($i=1; $i<=5; $i++)
                        <button type="button" class="star-btn" data-val="{{ $i }}">☆</button>
                        @endfor
                    </div>
                    <input type="hidden" name="{{ $field }}" id="input_{{ $field }}" value="3">
                </div>
                @endforeach
            </div>
            <div class="review-modal-text">
                <label class="review-text-label">Your Review</label>
                <textarea name="body" id="reviewText" placeholder="Share your thoughts about this fragrance..."></textarea>
            </div>
            <button type="submit" class="review-submit-btn">Submit Review</button>
        </form>
    </div>
</div>
@endauth

@endsection

@push('scripts')
<script>
/* ── Modal review ── */
@auth
const overlay  = document.getElementById('reviewModalOverlay');
const openBtn  = document.getElementById('openReviewModal');
const closeBtn = document.getElementById('closeReviewModal');
if (openBtn) openBtn.addEventListener('click', () => { overlay.classList.add('show'); document.body.style.overflow='hidden'; });
if (closeBtn) closeBtn.addEventListener('click', () => { overlay.classList.remove('show'); document.body.style.overflow=''; });
if (overlay) overlay.addEventListener('click', e => { if(e.target===overlay){ overlay.classList.remove('show'); document.body.style.overflow=''; }});

document.querySelectorAll('.star-rating').forEach(group => {
    const stars = group.querySelectorAll('.star-btn');
    const field = group.dataset.name;
    const hiddenInput = document.getElementById('input_' + field);
    let current = 3;
    // Init: show 3 stars
    stars.forEach((s,i) => s.textContent = i < 3 ? '★' : '☆');
    stars.forEach(star => {
        star.addEventListener('mouseenter', () => {
            const val = +star.dataset.val;
            stars.forEach((s,i) => s.textContent = i < val ? '★' : '☆');
        });
        star.addEventListener('mouseleave', () => {
            stars.forEach((s,i) => s.textContent = i < current ? '★' : '☆');
        });
        star.addEventListener('click', () => {
            current = +star.dataset.val;
            if (hiddenInput) hiddenInput.value = current;
            stars.forEach((s,i) => { s.textContent = i < current ? '★' : '☆'; s.classList.toggle('selected', i < current); });
        });
    });
});
@endauth

/* ── Favorite toggle ── */
const favBtn = document.getElementById('favBtn');
if (favBtn) {
    // Check current state
    fetch('{{ route("favorites.status") }}?slug={{ $product->slug }}')
        .then(r => r.json())
        .then(data => {
            if (data.is_favorite) favBtn.classList.add('active');
        }).catch(() => {});

    favBtn.addEventListener('click', () => {
        fetch('{{ route("favorites.toggle") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrf() },
            body: JSON.stringify({ slug: '{{ $product->slug }}' })
        })
        .then(r => r.json())
        .then(data => {
            favBtn.classList.toggle('active', data.is_favorite);
            showToast(data.is_favorite ? 'Ditambahkan ke favorit' : 'Dihapus dari favorit');
            if (typeof updateFavCount === 'function') updateFavCount(data.count);
        })
        .catch(() => showToast('Gagal memperbarui favorit', 'error'));
    });
}
</script>
@endpush
