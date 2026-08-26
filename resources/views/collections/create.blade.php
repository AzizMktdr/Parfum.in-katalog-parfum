@extends('layouts.app')

@section('title', 'Buat Koleksi — Parfum.in')

@section('content')

<div class="create-col-page">

    {{-- ── Left: Form ── --}}
    <div class="create-col-form-side">

        <div class="create-col-header">
            <a href="javascript:history.back()" class="create-col-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <h1 class="create-col-title">Buat Koleksi</h1>
            <p class="create-col-subtitle">Kurasi parfum favoritmu dalam satu koleksi</p>
        </div>

        <form method="POST" action="{{ route('collections.store') }}" id="createCollectionForm">
            @csrf

            {{-- Nama --}}
            <div class="ccf-field">
                <label class="ccf-label">Nama Koleksi</label>
                <input type="text" name="name" id="inputName"
                       class="ccf-input @error('name') ccf-error @enderror"
                       value="{{ old('name') }}"
                       placeholder="cth: Koleksi Musim Hujan"
                       maxlength="100"
                       autocomplete="off">
                @error('name')
                    <span class="ccf-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="ccf-field">
                <label class="ccf-label">
                    Deskripsi
                    <span class="ccf-label-hint">opsional</span>
                </label>
                <textarea name="description" id="inputDesc"
                          class="ccf-input ccf-textarea @error('description') ccf-error @enderror"
                          placeholder="Ceritakan tentang koleksi ini..."
                          maxlength="300">{{ old('description') }}</textarea>
                <div class="ccf-char-count"><span id="descCount">0</span>/300</div>
                @error('description')
                    <span class="ccf-error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Visibilitas --}}
            <div class="ccf-field">
                <label class="ccf-label">Visibilitas</label>
                <div class="ccf-visibility">
                    <label class="ccf-vis-option">
                        <input type="radio" name="is_public" value="1"
                               {{ old('is_public', '1') == '1' ? 'checked' : '' }}>
                        <span class="ccf-vis-card">
                            <span class="ccf-vis-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            </span>
                            <span class="ccf-vis-text">
                                <strong>Publik</strong>
                                <small>Semua orang bisa melihat</small>
                            </span>
                        </span>
                    </label>
                    <label class="ccf-vis-option">
                        <input type="radio" name="is_public" value="0"
                               {{ old('is_public') == '0' ? 'checked' : '' }}>
                        <span class="ccf-vis-card">
                            <span class="ccf-vis-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <span class="ccf-vis-text">
                                <strong>Privat</strong>
                                <small>Hanya kamu yang bisa lihat</small>
                            </span>
                        </span>
                    </label>
                </div>
            </div>

            {{-- Tambah Parfum --}}
            <div class="ccf-field">
                <label class="ccf-label">
                    Parfum
                    <span class="ccf-label-hint">opsional</span>
                </label>

                <div class="ccf-search-wrap" id="parfumSearchBar">
                    <svg class="ccf-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="parfumInput" class="ccf-search-input"
                           placeholder="Ketik nama parfum..." autocomplete="off">
                </div>

                {{-- Dropdown --}}
                <div class="ccf-dropdown" id="parfumDropdown"></div>

                {{-- Selected chips --}}
                <div class="ccf-chips" id="selectedChips"></div>

                {{-- Hidden inputs --}}
                <div id="hiddenInputs"></div>
            </div>

            {{-- Submit --}}
            <div class="ccf-actions">
                <button type="submit" class="ccf-btn-submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Buat Koleksi
                </button>
                <a href="javascript:history.back()" class="ccf-btn-cancel">Batal</a>
            </div>

        </form>
    </div>

    {{-- ── Right: Live Preview ── --}}
    <div class="create-col-preview-side">
        <div class="create-col-preview-sticky">
            <p class="ccf-preview-label">Preview</p>

            <div class="ccf-preview-card">
                {{-- Mosaic parfum --}}
                <div class="ccf-preview-mosaic" id="previewMosaic">
                    <div class="ccf-preview-empty-grid">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12h14"/></svg>
                        <span>Tambahkan parfum</span>
                    </div>
                </div>

                {{-- Info --}}
                <div class="ccf-preview-info">
                    <p class="ccf-preview-name" id="previewName">Nama Koleksi</p>
                    <p class="ccf-preview-desc" id="previewDesc">Deskripsi akan muncul di sini...</p>
                    <div class="ccf-preview-meta">
                        <span id="previewCount">0 parfum</span>
                        <span class="ccf-preview-dot">·</span>
                        <span id="previewVis">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            Publik
                        </span>
                    </div>
                </div>
            </div>

            <p class="ccf-preview-hint">Tampilan koleksimu di profil</p>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<style>
/* ═══════════════════════════
   PAGE LAYOUT
═══════════════════════════ */
.create-col-page {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 0;
    min-height: calc(100vh - 60px);
}

/* ── Left Side ── */
.create-col-form-side {
    padding: 56px 60px 80px;
    border-right: 1px solid var(--border);
    max-width: 600px;
    width: 100%;
    justify-self: end;
}

.create-col-header { margin-bottom: 44px; }

.create-col-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--text-muted);
    text-decoration: none;
    margin-bottom: 20px;
    transition: color 0.15s;
}
.create-col-back:hover { color: var(--text); }

.create-col-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.02em;
    margin: 0 0 8px;
}
.create-col-subtitle {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin: 0;
}

/* ── Fields ── */
.ccf-field { margin-bottom: 28px; }

.ccf-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--text);
    margin-bottom: 10px;
}
.ccf-label-hint {
    font-size: 0.55rem;
    font-weight: 400;
    color: var(--text-muted);
    letter-spacing: 0.04em;
    text-transform: none;
    background: var(--bg-secondary);
    padding: 2px 8px;
    border-radius: 20px;
}

.ccf-input {
    width: 100%;
    box-sizing: border-box;
    background: var(--bg-secondary);
    border: 1.5px solid transparent;
    border-radius: 12px;
    color: var(--text);
    font-family: 'Poppins', sans-serif;
    font-size: 0.78rem;
    padding: 13px 16px;
    outline: none;
    transition: border-color 0.2s, background 0.2s;
}
.ccf-input::placeholder { color: var(--text-light); }
.ccf-input:focus {
    border-color: var(--text);
    background: var(--card-bg);
}
.ccf-input.ccf-error { border-color: #e74c3c; }

.ccf-textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.7;
}

.ccf-char-count {
    text-align: right;
    font-size: 0.55rem;
    color: var(--text-muted);
    margin-top: 4px;
}

.ccf-error-msg {
    display: block;
    font-size: 0.6rem;
    color: #e74c3c;
    margin-top: 6px;
}

/* ── Visibility ── */
.ccf-visibility { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

.ccf-vis-option input[type=radio] { display: none; }

.ccf-vis-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: var(--bg-secondary);
    border: 1.5px solid transparent;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.15s;
}
.ccf-vis-card:hover { border-color: var(--border); background: var(--card-bg); }
.ccf-vis-option input:checked + .ccf-vis-card {
    border-color: var(--text);
    background: var(--card-bg);
}

.ccf-vis-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--bg);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background 0.15s;
}
.ccf-vis-option input:checked + .ccf-vis-card .ccf-vis-icon {
    background: var(--text);
    border-color: var(--text);
    color: var(--bg);
}

.ccf-vis-text { display: flex; flex-direction: column; gap: 2px; }
.ccf-vis-text strong { font-size: 0.68rem; font-weight: 700; color: var(--text); }
.ccf-vis-text small { font-size: 0.57rem; color: var(--text-muted); }

/* ── Parfum Search ── */
.ccf-search-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-secondary);
    border: 1.5px solid transparent;
    border-radius: 12px;
    padding: 0 14px;
    transition: border-color 0.2s, background 0.2s;
}
.ccf-search-wrap:focus-within {
    border-color: var(--text);
    background: var(--card-bg);
}
.ccf-search-icon { color: var(--text-muted); flex-shrink: 0; }
.ccf-search-input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: var(--text);
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    padding: 13px 0;
}
.ccf-search-input::placeholder { color: var(--text-light); }

/* Dropdown */
.ccf-dropdown {
    background: var(--card-bg);
    border: 1.5px solid var(--border);
    border-radius: 12px;
    margin-top: 6px;
    overflow: hidden;
    display: none;
    box-shadow: var(--shadow-md);
    position: relative;
    z-index: 50;
}
.ccf-dropdown.show { display: block; }

.ccf-drop-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    cursor: pointer;
    border-bottom: 1px solid var(--border);
    transition: background 0.12s;
}
.ccf-drop-item:last-child { border-bottom: none; }
.ccf-drop-item:hover { background: var(--bg-secondary); }
.ccf-drop-item.added { opacity: 0.35; pointer-events: none; }

.ccf-drop-img {
    width: 40px; height: 40px;
    border-radius: 8px;
    object-fit: contain;
    background: var(--bg-secondary);
    flex-shrink: 0;
}
.ccf-drop-name { font-size: 0.63rem; font-weight: 700; letter-spacing: 0.03em; color: var(--text); }
.ccf-drop-brand { font-size: 0.57rem; color: var(--text-muted); margin-top: 1px; }
.ccf-drop-added-badge {
    margin-left: auto;
    font-size: 0.52rem;
    color: var(--text-muted);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2px 8px;
}

/* Chips */
.ccf-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}
.ccf-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--text);
    color: var(--bg);
    border-radius: 20px;
    padding: 5px 12px 5px 10px;
    font-size: 0.62rem;
    font-weight: 600;
    animation: chipIn 0.2s ease;
}
@keyframes chipIn {
    from { opacity: 0; transform: scale(0.85); }
    to   { opacity: 1; transform: scale(1); }
}
.ccf-chip-img {
    width: 18px; height: 18px;
    border-radius: 4px;
    object-fit: contain;
    background: var(--bg-secondary);
    filter: invert(1) brightness(0);
}
.dark-mode .ccf-chip-img { filter: none; }
.ccf-chip-remove {
    background: none;
    border: none;
    color: inherit;
    opacity: 0.6;
    cursor: pointer;
    padding: 0;
    font-size: 1rem;
    line-height: 1;
    transition: opacity 0.15s;
}
.ccf-chip-remove:hover { opacity: 1; }

/* ── Actions ── */
.ccf-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-top: 36px;
}
.ccf-btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--text);
    color: var(--bg);
    border: none;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 14px 28px;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.15s;
}
.ccf-btn-submit:hover { opacity: 0.85; transform: translateY(-1px); }
.ccf-btn-cancel {
    font-size: 0.62rem;
    font-weight: 600;
    color: var(--text-muted);
    text-decoration: none;
    transition: color 0.15s;
}
.ccf-btn-cancel:hover { color: var(--text); }

/* ═══════════════════════════
   RIGHT: PREVIEW
═══════════════════════════ */
.create-col-preview-side {
    padding: 56px 48px 80px;
    background: var(--bg-secondary);
}
.create-col-preview-sticky { position: sticky; top: 80px; }

.ccf-preview-label {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin: 0 0 16px;
}

.ccf-preview-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

/* Mosaic grid */
.ccf-preview-mosaic {
    aspect-ratio: 16/9;
    background: var(--bg-secondary);
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    overflow: hidden;
}
.ccf-preview-mosaic-img {
    aspect-ratio: 1;
    object-fit: contain;
    background: var(--bg-secondary);
    width: 100%;
}
.ccf-preview-empty-grid {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 0.62rem;
}

.ccf-preview-info { padding: 16px 18px 18px; }
.ccf-preview-name {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 6px;
    letter-spacing: 0.02em;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ccf-preview-desc {
    font-size: 0.62rem;
    color: var(--text-muted);
    margin: 0 0 12px;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ccf-preview-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.58rem;
    color: var(--text-muted);
}
.ccf-preview-dot { opacity: 0.4; }
#previewVis { display: inline-flex; align-items: center; gap: 4px; }

.ccf-preview-hint {
    font-size: 0.57rem;
    color: var(--text-muted);
    text-align: center;
    margin: 12px 0 0;
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .create-col-page { grid-template-columns: 1fr; }
    .create-col-form-side { padding: 40px 24px 60px; max-width: 100%; justify-self: auto; border-right: none; }
    .create-col-preview-side { display: none; }
}
</style>

<script>
const selectedProducts = {};
const inputEl    = document.getElementById('parfumInput');
const dropdown   = document.getElementById('parfumDropdown');
const chipsEl    = document.getElementById('selectedChips');
const hiddenEl   = document.getElementById('hiddenInputs');
const nameInput  = document.getElementById('inputName');
const descInput  = document.getElementById('inputDesc');
const descCount  = document.getElementById('descCount');
const prevName   = document.getElementById('previewName');
const prevDesc   = document.getElementById('previewDesc');
const prevCount  = document.getElementById('previewCount');
const prevVis    = document.getElementById('previewVis');
const prevMosaic = document.getElementById('previewMosaic');

let debounce;

// ── Live preview ──
nameInput.addEventListener('input', () => {
    prevName.textContent = nameInput.value.trim() || 'Nama Koleksi';
});
descInput.addEventListener('input', () => {
    const len = descInput.value.length;
    descCount.textContent = len;
    prevDesc.textContent = descInput.value.trim() || 'Deskripsi akan muncul di sini...';
});
document.querySelectorAll('input[name="is_public"]').forEach(r => {
    r.addEventListener('change', () => {
        const isPublic = r.value === '1';
        prevVis.innerHTML = isPublic
            ? `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg> Publik`
            : `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Privat`;
    });
});

// ── Search ──
inputEl.addEventListener('input', () => {
    clearTimeout(debounce);
    const q = inputEl.value.trim();
    if (q.length < 2) { closeDropdown(); return; }
    debounce = setTimeout(() => fetchProducts(q), 250);
});
inputEl.addEventListener('keydown', e => { if (e.key === 'Escape') closeDropdown(); });
document.addEventListener('click', e => {
    if (!e.target.closest('#parfumSearchBar') && !e.target.closest('#parfumDropdown')) closeDropdown();
});

function fetchProducts(q) {
    fetch(`/api/search-products?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(renderDropdown)
        .catch(() => closeDropdown());
}

function renderDropdown(products) {
    dropdown.innerHTML = '';
    if (!products.length) {
        dropdown.innerHTML = '<div style="padding:16px;text-align:center;font-size:0.62rem;color:var(--text-muted)">Parfum tidak ditemukan</div>';
        dropdown.classList.add('show');
        return;
    }
    products.slice(0, 8).forEach(p => {
        const isAdded = !!selectedProducts[p.slug];
        const item = document.createElement('div');
        item.className = 'ccf-drop-item' + (isAdded ? ' added' : '');
        item.innerHTML = `
            <img class="ccf-drop-img" src="${p.image}" alt="" onerror="this.style.opacity='0.15'">
            <div>
                <div class="ccf-drop-name">${p.name}</div>
                <div class="ccf-drop-brand">${p.brand ?? ''}</div>
            </div>
            ${isAdded ? '<span class="ccf-drop-added-badge">Ditambahkan</span>' : ''}`;
        if (!isAdded) item.addEventListener('click', () => addProduct(p));
        dropdown.appendChild(item);
    });
    dropdown.classList.add('show');
}

function addProduct(p) {
    if (selectedProducts[p.slug]) return;
    selectedProducts[p.slug] = p;

    // Chip
    const chip = document.createElement('div');
    chip.className = 'ccf-chip';
    chip.dataset.slug = p.slug;
    chip.innerHTML = `
        <img class="ccf-chip-img" src="${p.image}" alt="" onerror="this.style.display='none'">
        <span>${p.name}</span>
        <button type="button" class="ccf-chip-remove" title="Hapus">×</button>`;
    chip.querySelector('.ccf-chip-remove').addEventListener('click', () => removeProduct(p.slug));
    chipsEl.appendChild(chip);

    // Hidden input
    const inp = document.createElement('input');
    inp.type = 'hidden'; inp.name = 'products[]';
    inp.value = p.slug; inp.id = `hidden_${p.slug}`;
    hiddenEl.appendChild(inp);

    updateMosaic();
    inputEl.value = '';
    closeDropdown();
    inputEl.focus();
}

function removeProduct(slug) {
    delete selectedProducts[slug];
    chipsEl.querySelector(`[data-slug="${slug}"]`)?.remove();
    document.getElementById(`hidden_${slug}`)?.remove();
    updateMosaic();
}

function updateMosaic() {
    const products = Object.values(selectedProducts);
    prevCount.textContent = `${products.length} parfum`;

    if (!products.length) {
        prevMosaic.innerHTML = `
            <div class="ccf-preview-empty-grid">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 5v14M5 12h14"/></svg>
                <span>Tambahkan parfum</span>
            </div>`;
        return;
    }

    const cols = Math.min(products.length, 3);
    prevMosaic.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
    prevMosaic.innerHTML = products.slice(0, 3).map(p =>
        `<img class="ccf-preview-mosaic-img" src="${p.image}" alt="${p.name}" onerror="this.style.opacity='0.1'">`
    ).join('');
}

function closeDropdown() {
    dropdown.classList.remove('show');
    dropdown.innerHTML = '';
}
</script>
@endpush
