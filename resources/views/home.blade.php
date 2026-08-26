@extends('layouts.app')

@section('title', 'Parfum.in - Temukan Parfum Terbaik')

@section('content')

{{-- ═══════════════════════════════════════
     HERO CAROUSEL
     Layout: persis seperti referensi gambar
     - Watermark teks besar: tengah (z:1)
     - Botol miring: tengah-kiri (z:3)
     - Title: kanan atas (z:2)
     - Desc: kiri bawah (z:2)
     - Button: kanan bawah (z:4)
     ═══════════════════════════════════════ --}}
<section class="hero-carousel">

    <button class="carousel-btn prev" id="prevBtn">&#8249;</button>

    <div id="carouselTrack">
        @foreach($slides as $i => $slide)
        <div class="carousel-slide {{ $i === 0 ? 'active' : '' }}"
             @if(!empty($slide['bg_color'])) style="background-color: {{ $slide['bg_color'] }};" @endif>

            {{-- 1. Watermark besar di belakang (z-index:1) --}}
            <span class="slide-watermark">{{ $slide['watermark'] }}</span>

            {{-- 2. Title kanan atas (z-index:2) --}}
            <h1 class="slide-title">{!! nl2br(e($slide['title'])) !!}</h1>

            {{-- 3. Gambar produk (z-index:3) --}}
            <div class="slide-image">
                <img
                    src="{{ $slide['image'] }}"
                    alt="{{ $slide['title'] }}"
                    class="product-image"
                    onerror="this.style.opacity='0.12'"
                >
            </div>

            {{-- 4. Deskripsi kiri bawah (z-index:2) --}}
            <p class="slide-desc">{{ $slide['description'] }}</p>

            {{-- 5. Tombol kanan bawah (z-index:4) --}}
            <a href="{{ $slide['link'] }}" class="btn-detail">{{ $slide['button_text'] ?? 'Lihat Detail' }}</a>

        </div>
        @endforeach
    </div>

    <button class="carousel-btn next" id="nextBtn">&#8250;</button>

    <div class="carousel-dots">
        @foreach($slides as $i => $slide)
            <span class="dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
        @endforeach
    </div>

</section>


{{-- ═══════════════════════════════════════
     KOLEKSI EKSKLUSIF
     ═══════════════════════════════════════ --}}
<div class="koleksi-section">

    <div class="section-header">
        <h2 class="section-title">Koleksi Eksklusif</h2>
        <p class="section-subtitle">Temukan parfum eksklusif untuk setiap momen</p>
    </div>

    {{-- NIGHT --}}
    <div class="koleksi-group">
        <div class="koleksi-group-header">
            <span class="koleksi-group-title">Night</span>
            <a href="{{ route('fragrances.index') }}" class="see-more">See more →</a>
        </div>
        <p class="koleksi-group-sub">The most suitable perfume for the evening.</p>

        <div class="product-grid">
            @foreach($night_products as $product)
            <a href="{{ route('product.detail', $product['slug']) }}" class="product-card">
                <div class="product-card-img">
                    {{--
                    ╔══════════════════════════════════════╗
                    ║  📁 LETAK GAMBAR PRODUK NIGHT:       ║
                    ║     public/images/products/          ║
                    ║     night-1.png  night-2.png  dst.   ║
                    ╚══════════════════════════════════════╝
                    --}}
                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">{{ $product['name'] }}</span>
                <span class="product-card-brand">{{ $product['brand'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- DAY --}}
    <div class="koleksi-group">
        <div class="koleksi-group-header">
            <span class="koleksi-group-title">Day</span>
            <a href="#" class="see-more">See more →</a>
        </div>
        <p class="koleksi-group-sub">The most suitable perfume for the morning.</p>

        <div class="product-grid">
            @foreach($day_products as $product)
            <a href="{{ route('product.detail', $product['slug']) }}" class="product-card">
                <div class="product-card-img">
                    {{--
                    ╔══════════════════════════════════════╗
                    ║  📁 LETAK GAMBAR PRODUK DAY:         ║
                    ║     public/images/products/          ║
                    ║     day-2.png  day-3.png  dst.       ║
                    ╚══════════════════════════════════════╝
                    --}}
                    <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" onerror="this.style.opacity='0.1'">
                </div>
                <span class="product-card-name">{{ $product['name'] }}</span>
                <span class="product-card-brand">{{ $product['brand'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

</div>


{{-- ═══════════════════════════════════════
     BRANDS
     ═══════════════════════════════════════ --}}
<div class="brands-section">
    <div class="section-header">
        <h2 class="section-title">Brands</h2>
    </div>

    <div class="brands-grid">
        @foreach($brands as $brand)
        <a href="{{ route('brands.show', $brand['slug']) }}" class="brand-card" style="text-decoration:none;">
            <div class="brand-circle">
                <img src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] }}" onerror="this.style.opacity='0'">
            </div>
            <span class="brand-name">{{ $brand['name'] }}</span>
        </a>
        @endforeach
    </div>

    <div style="text-align:center; margin-top:16px;">
        <a href="{{ route('brands.index') }}" class="see-more">See All Brands →</a>
    </div>
</div>


{{-- ═══════════════════════════════════════
     PARFUM.IN RECOMMENDATIONS (dark bg)
     ═══════════════════════════════════════ --}}
<section class="recommendations-section">
    <div class="reco-inner">
        <div class="section-header">
            <h2 class="section-title">Parfum.in Recommendations</h2>
            <p class="section-subtitle">Pilihan terbaik dari para ahli kami</p>
        </div>

        <div class="reco-grid">
            @foreach($recommendations as $reco)
            <a href="{{ route('product.detail', $reco['slug']) }}" class="reco-card">
                <div class="reco-card-img">
                    {{--
                    ╔══════════════════════════════════════════╗
                    ║  📁 LETAK GAMBAR REKOMENDASI:            ║
                    ║     public/images/products/              ║
                    ║  Ganti nama file di HomeController.php   ║
                    ╚══════════════════════════════════════════╝
                    --}}
                    <img src="{{ asset($reco['image']) }}" alt="{{ $reco['name'] }}" onerror="this.style.opacity='0.1'">
                </div>
                <span class="reco-card-name">{{ $reco['name'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════
     GUIDE TO USING PERFUME
     ═══════════════════════════════════════ --}}
<div class="guide-section">
    <div class="section-header">
        <h2 class="section-title">Guide to Using Perfume</h2>
        <p class="section-subtitle">Tips penggunaan parfum yang tepat</p>
    </div>

    <div class="guide-grid">
        @foreach($guides as $guide)
        <div class="guide-card">
            <div class="guide-num">{{ $guide['num'] }}</div>
            <div class="guide-body">
                <div class="guide-card-title">{{ $guide['title'] }}</div>
                <p class="guide-card-text">{{ $guide['text'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>


{{-- ═══════════════════════════════════════
     FOOTER
     ═══════════════════════════════════════ --}}
<footer class="footer">
    <div class="footer-inner">

        <div class="footer-col">
            <div class="footer-col-title">Fragrances</div>
            <ul>
                <li><a href="#">Brands</a></li>
                <li><a href="#">Notes</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <div class="footer-col-title">Privacy Policy</div>
            <ul>
                <li><a href="#">Terms and Conditions</a></li>
                <li><a href="#">Cookies Policy</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <div class="footer-col-title">Contact</div>
            <p>Parfum.in@gmail.com</p>
        </div>

        <div class="footer-col">
            <div class="footer-col-title">Follow Us at</div>
            <ul>
                <li><a href="#">Instagram</a></li>
                <li><a href="#">TikTok</a></li>
                <li><a href="#">Twitter / X</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <span class="footer-logo">PARFUM.IN</span>
        <span class="footer-bottom-text">© {{ date('Y') }} Parfum.in. All rights reserved.</span>
    </div>
</footer>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

// ── Carousel ──────────────────────────────────────────
const slides = document.querySelectorAll('.carousel-slide');
const dots   = document.querySelectorAll('.dot');
let current  = 0, timer;

function goTo(i) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = (i + slides.length) % slides.length;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
}

function startAuto() { timer = setInterval(() => goTo(current + 1), 5000); }
function resetAuto()  { clearInterval(timer); startAuto(); }

document.getElementById('prevBtn').addEventListener('click', () => { goTo(current - 1); resetAuto(); });
document.getElementById('nextBtn').addEventListener('click', () => { goTo(current + 1); resetAuto(); });
dots.forEach(d => d.addEventListener('click', () => { goTo(+d.dataset.index); resetAuto(); }));

startAuto();

// ── Filter Dropdown ─────────────────────────────
const filterBtn      = document.getElementById('filterBtn');
const filterMenu     = document.getElementById('filterMenu');
const filterLabel    = document.getElementById('filterLabel');
const mainSearchInput = document.getElementById('mainSearchInput');
if (filterBtn) {
    filterBtn.addEventListener('click', e => {
        e.stopPropagation();
        filterBtn.classList.toggle('open');
        filterMenu.classList.toggle('show');
    });
    filterMenu.querySelectorAll('li').forEach(li => {
        li.addEventListener('click', () => {
            filterMenu.querySelectorAll('li').forEach(x => x.classList.remove('selected'));
            li.classList.add('selected');
            filterLabel.textContent = li.textContent.trim();
            filterBtn.classList.remove('open');
            filterMenu.classList.remove('show');
            if (mainSearchInput) {
                mainSearchInput.placeholder = li.dataset.value === 'all' ? 'search...' : `Search by ${li.textContent.replace('Search by ', '')}...`;
                mainSearchInput.focus();
            }
        });
    });
    document.addEventListener('click', () => {
        filterBtn.classList.remove('open');
        filterMenu.classList.remove('show');
    });
}

}); // end DOMContentLoaded
</script>
@endpush
