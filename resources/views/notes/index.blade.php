@extends('layouts.app')
@section('title', 'Notes — Parfum.in')
@section('content')

<div class="notes-page">

    <h1 class="notes-page-title">Notes</h1>

    {{-- Search bar dengan tag chips --}}
    <div class="notes-searchbar-outer">
        <div class="notes-search-bar" id="notesSearchBar">
            <button class="notes-filter-all active" id="notesFilterAll">All</button>
            <div class="notes-tags-wrap" id="notesTagsWrap"></div>
            <input type="text" class="notes-search-input" id="notesSearchInput" placeholder="search..." autocomplete="off">
            <button class="notes-search-icon">⌕</button>
        </div>
    </div>

    {{-- Info notes terpilih --}}
    <div class="notes-selected-summary" id="notesSelectedSummary" style="display:none">
        <span id="notesSummaryText"></span>
        <button class="notes-clear-all" id="notesClearAll">Clear all ×</button>
    </div>

    {{-- Grup notes --}}
    @foreach($groups as $group)
    <div class="notes-group">
        <div class="notes-group-header">
            <span class="notes-group-title">{{ $group['name'] }}</span>
            <a href="#" class="see-more">See more</a>
        </div>
        <div class="notes-grid">
            @foreach($group['notes'] as $note)
            <div class="note-card" data-name="{{ $note['name'] }}" data-group="{{ $group['slug'] }}">
                <div class="note-img-wrap">
                    {{--
                    ╔══════════════════════════════════════════╗
                    ║  📁 GAMBAR NOTE (lingkaran):             ║
                    ║     public/images/notes/{nama-note}.png  ║
                    ║     Contoh: bergamot.png, lemon.png      ║
                    ║     Ukuran ideal: 200×200px, PNG/JPG     ║
                    ╚══════════════════════════════════════════╝
                    --}}
                    <img src="{{ asset($note['image']) }}"
                         alt="{{ $note['name'] }}"
                         onerror="this.style.opacity='0.15'">
                    <button class="note-add-btn" title="Tambah ke pencarian">+</button>
                </div>
                <span class="note-name">{{ $note['name'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div style="text-align:center;padding:16px 0 40px">
        <a href="#" class="see-all-link">See all</a>
    </div>
</div>

@include('partials.footer')
@endsection

@push('scripts')
<script>
/* ══════════════════════════════════════════════════
   NOTES — multi-select ke search bar chips
══════════════════════════════════════════════════ */
const tagsWrap    = document.getElementById('notesTagsWrap');
const searchInput = document.getElementById('notesSearchInput');
const summary     = document.getElementById('notesSelectedSummary');
const summaryText = document.getElementById('notesSummaryText');
const clearAllBtn = document.getElementById('notesClearAll');
const filterAll   = document.getElementById('notesFilterAll');

let selectedNotes = [];

function addNote(name) {
    if (selectedNotes.includes(name)) return;
    selectedNotes.push(name);
    renderTags(); updateSummary();
}

function removeNote(name) {
    selectedNotes = selectedNotes.filter(n => n !== name);
    renderTags(); updateSummary();
    document.querySelectorAll('.note-card').forEach(card => {
        if (card.dataset.name === name) {
            card.classList.remove('selected');
            card.querySelector('.note-add-btn').textContent = '+';
        }
    });
}

function renderTags() {
    tagsWrap.innerHTML = '';
    selectedNotes.forEach(name => {
        const chip = document.createElement('span');
        chip.className = 'note-tag-chip';
        chip.innerHTML = `${name} <button class="note-tag-remove" data-name="${name}">×</button>`;
        tagsWrap.appendChild(chip);
    });
    tagsWrap.querySelectorAll('.note-tag-remove').forEach(btn => {
        btn.addEventListener('click', e => { e.stopPropagation(); removeNote(btn.dataset.name); });
    });
    searchInput.placeholder = selectedNotes.length > 0 ? '' : 'search...';
    filterAll.classList.toggle('active', selectedNotes.length === 0);
}

function updateSummary() {
    if (selectedNotes.length === 0) { summary.style.display = 'none'; return; }
    summary.style.display = 'flex';
    summaryText.textContent = `${selectedNotes.length} note dipilih: ${selectedNotes.join(', ')}`;
}

clearAllBtn.addEventListener('click', () => {
    const names = [...selectedNotes];
    names.forEach(n => removeNote(n));
});

/* Klik tombol + */
document.querySelectorAll('.note-add-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault(); e.stopPropagation();
        const card = btn.closest('.note-card');
        const name = card.dataset.name;
        if (selectedNotes.includes(name)) {
            removeNote(name);
        } else {
            card.classList.add('selected');
            btn.textContent = '✓';
            addNote(name);
        }
    });
});

/* Filter live ketik */
searchInput.addEventListener('input', () => {
    const q = searchInput.value.toLowerCase().trim();
    document.querySelectorAll('.note-card').forEach(card => {
        card.style.display = (!q || card.dataset.name.toLowerCase().includes(q)) ? '' : 'none';
    });
});
</script>
@endpush
