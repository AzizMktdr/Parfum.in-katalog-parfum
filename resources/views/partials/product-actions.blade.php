{{--
    Partial: product-actions
    Variabel yang dibutuhkan:
    - $slug  : string slug produk
    - $name  : string nama produk  
    - $brand : string brand produk
    - $image : string path gambar produk
--}}

{{-- ── Tombol Aksi (Favorit) ── --}}
<div class="detail-action-row">
    <button class="btn-fav" id="favBtn" data-slug="{{ $slug }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
        </svg>
        <span id="favBtnText">Simpan</span>
    </button>
</div>

{{-- ── Daftar Review dari DB ── --}}
<div class="detail-reviews-section">
    <div class="detail-reviews-title">Review by Users</div>
    <div id="reviewsList">
        <p class="reviews-loading">Memuat review...</p>
    </div>
    <div class="review-actions">
        <a href="/product/{{ $slug }}/reviews" class="btn-outline-sm">See all reviews</a>
        <button class="btn-outline-sm" id="openReviewModal">Write a Review</button>
    </div>
</div>

{{-- ── Modal Write Review ── --}}
<div class="modal-overlay" id="reviewModalOverlay">
    <div class="modal-box review-modal">
        <button class="modal-close" id="closeReviewModal">×</button>
        <h2 class="modal-title">Share Your Experience</h2>

        <div class="review-modal-ratings">
            @foreach(['Sillage','Projection','Longevity'] as $rn)
            <div class="review-rating-group">
                <span class="review-rating-label">{{ $rn }}</span>
                <div class="star-rating" data-name="{{ strtolower($rn) }}">
                    @for($i=1;$i<=5;$i++)
                    <button type="button" class="star-btn" data-val="{{ $i }}">☆</button>
                    @endfor
                </div>
            </div>
            @endforeach
        </div>

        <div class="review-modal-text">
            <label class="review-text-label">Your Review</label>
            <textarea id="reviewText" placeholder="Share your thoughts about this fragrance..."></textarea>
        </div>

        <button class="review-submit-btn" id="submitReview">Submit Review</button>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const SLUG    = "{{ $slug }}";
    const IS_AUTH = {{ Auth::check() ? 'true' : 'false' }};

    /* ── Load reviews ── */
    function loadReviews() {
        fetch(`/product/${SLUG}/reviews`)
            .then(r => r.json())
            .then(data => {
                const list = document.getElementById('reviewsList');
                if (!data.reviews || data.reviews.length === 0) {
                    list.innerHTML = '<p style="font-size:0.72rem;color:var(--text-muted);padding:12px 0">Belum ada review. Jadilah yang pertama!</p>';
                    return;
                }
                list.innerHTML = data.reviews.slice(0, 3).map(r => {
                    const avg = Math.round((r.sillage + r.projection + r.longevity) / 3);
                    return `<div class="review-card">
                        <div class="review-header">
                            <span class="review-author">${r.author}</span>
                            <span class="review-date">${r.date}</span>
                        </div>
                        <div class="review-stars">${'★'.repeat(avg)}${'☆'.repeat(5 - avg)}</div>
                        <div class="review-tags">
                            <span class="review-tag">Sillage: <strong>${r.sillage}/5</strong></span>
                            <span class="review-tag">Projection: <strong>${r.projection}/5</strong></span>
                            <span class="review-tag">Longevity: <strong>${r.longevity}/5</strong></span>
                        </div>
                        <p class="review-text">${r.text}</p>
                    </div>`;
                }).join('');
            })
            .catch(() => {
                document.getElementById('reviewsList').innerHTML =
                    '<p style="font-size:0.72rem;color:var(--text-muted)">Gagal memuat review.</p>';
            });
    }
    loadReviews();

    /* ── Favorit toggle ── */
    const favBtn  = document.getElementById('favBtn');
    const favText = document.getElementById('favBtnText');

    fetch(`/favorites/status?slug=${SLUG}`)
        .then(r => r.json())
        .then(d => {
            if (d.is_favorite) { favBtn.classList.add('favorited'); favText.textContent = 'Tersimpan'; }
            if (typeof updateFavCount === 'function') updateFavCount(d.count);
        }).catch(() => {});

    favBtn.addEventListener('click', () => {
        if (!IS_AUTH) { showLoginRequired('Login untuk menyimpan ke favorit.'); return; }
        fetch('/favorites/toggle', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrf() },
            body: JSON.stringify({ slug: SLUG })
        })
        .then(r => r.json())
        .then(d => {
            if (d.is_favorite) {
                favBtn.classList.add('favorited'); favText.textContent = 'Tersimpan';
                showToast('Ditambahkan ke favorit!', 'success');
            } else {
                favBtn.classList.remove('favorited'); favText.textContent = 'Simpan';
                showToast('Dihapus dari favorit.', 'success');
            }
            if (typeof updateFavCount === 'function') updateFavCount(d.count);
        })
        .catch(() => showToast('Terjadi kesalahan.', 'error'));
    });

    /* ── Modal Review ── */
    const overlay  = document.getElementById('reviewModalOverlay');
    const openBtn  = document.getElementById('openReviewModal');
    const closeBtn = document.getElementById('closeReviewModal');

    openBtn.addEventListener('click', () => {
        if (!IS_AUTH) { showLoginRequired('Login untuk menulis review.'); return; }
        overlay.classList.add('show'); document.body.style.overflow = 'hidden';
    });
    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(); });
    function closeModal() { overlay.classList.remove('show'); document.body.style.overflow = ''; }

    /* ── Star ratings ── */
    const ratings = { sillage: 0, projection: 0, longevity: 0 };
    document.querySelectorAll('.star-rating').forEach(group => {
        const name  = group.dataset.name;
        const stars = group.querySelectorAll('.star-btn');
        stars.forEach(star => {
            star.addEventListener('mouseenter', () => {
                const v = +star.dataset.val;
                stars.forEach((s, i) => s.textContent = i < v ? '★' : '☆');
            });
            star.addEventListener('mouseleave', () => {
                stars.forEach((s, i) => s.textContent = i < ratings[name] ? '★' : '☆');
            });
            star.addEventListener('click', () => {
                ratings[name] = +star.dataset.val;
                stars.forEach((s, i) => { s.textContent = i < ratings[name] ? '★' : '☆'; s.classList.toggle('selected', i < ratings[name]); });
            });
        });
    });

    /* ── Submit review (AJAX untuk halaman statis) ── */
    document.getElementById('submitReview').addEventListener('click', () => {
        const text = document.getElementById('reviewText').value.trim();
        if (!ratings.sillage || !ratings.projection || !ratings.longevity) {
            showToast('Lengkapi semua rating bintang.', 'error'); return;
        }
        if (!text || text.length < 10) {
            showToast('Review minimal 10 karakter.', 'error'); return;
        }
        const submitBtn = document.getElementById('submitReview');
        submitBtn.textContent = 'Mengirim...'; submitBtn.disabled = true;

        fetch(`/product/${SLUG}/review`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrf() },
            body: JSON.stringify({
                sillage: ratings.sillage,
                projection: ratings.projection,
                longevity: ratings.longevity,
                body: text,
            })
        })
        .then(async r => {
            const d = await r.json().catch(() => ({}));
            if (r.ok || d.success) {
                showToast('Review berhasil dikirim!', 'success');
                closeModal();
                loadReviews();
                document.getElementById('reviewText').value = '';
                Object.keys(ratings).forEach(k => ratings[k] = 0);
                document.querySelectorAll('.star-btn').forEach(s => { s.textContent = '☆'; s.classList.remove('selected'); });
            } else if (d.require_login) {
                closeModal(); showLoginRequired(d.message);
            } else {
                showToast(d.message || 'Terjadi kesalahan.', 'error');
            }
        })
        .catch(() => showToast('Terjadi kesalahan koneksi.', 'error'))
        .finally(() => { submitBtn.textContent = 'Submit Review'; submitBtn.disabled = false; });
    });
})();
</script>
@endpush
