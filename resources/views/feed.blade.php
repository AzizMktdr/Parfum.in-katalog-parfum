@extends('layouts.app')

@section('title', 'Community — Parfum.in')

@push('styles')
@endpush

@section('content')
<div class="community-page">

    {{-- Header --}}
    <div class="community-header">
        <h1 class="community-title">Community</h1>
        @auth
            @if($tab === 'discussions')
                <button class="btn-new-collection" id="openNewDiscussion">+ Diskusi Baru</button>
            @else
                <a href="{{ route('collections.create') }}" class="btn-new-collection">+ Buat Koleksi</a>
            @endif
        @endauth
    </div>

    {{-- Tabs --}}
    <div class="feed-tabs">
        <a href="{{ route('community') }}?tab=discussions"
           class="feed-tab {{ $tab === 'discussions' ? 'active' : '' }}">💬 Diskusi</a>
        <a href="{{ route('community') }}?tab=collections"
           class="feed-tab {{ $tab === 'collections' ? 'active' : '' }}">🧴 Koleksi</a>
    </div>

    {{-- ═══ TAB: DISKUSI ═══ --}}
    @if($tab === 'discussions')

        {{-- Form diskusi baru --}}
        @auth
        <div class="new-discussion-box" id="newDiscussionBox" style="display:none">
            <form method="POST" action="{{ route('discussion.store') }}">
                @csrf
                <input type="text" name="title" class="discussion-title-input"
                       placeholder="Judul diskusi..." maxlength="200" required
                       value="{{ old('title') }}">
                <textarea name="body" class="discussion-body-input"
                          placeholder="Tulis sesuatu tentang parfum, review, tips, atau apapun..."
                          maxlength="5000" required>{{ old('body') }}</textarea>
                <div class="discussion-form-actions">
                    <button type="button" class="btn-cancel-edit" id="cancelDiscussion">Batal</button>
                    <button type="submit" class="btn-auth-submit" style="width:auto;padding:9px 22px">Posting</button>
                </div>
            </form>
        </div>
        @endauth

        @if($discussions->isEmpty())
            <div class="feed-empty">
                <div class="feed-empty-icon">💬</div>
                <p>Belum ada diskusi. Mulai yang pertama!</p>
            </div>
        @else
        <div class="feed-list">
            @foreach($discussions as $d)
            @php $isLiked = in_array($d->id, $likedIds); @endphp

            {{-- Card pakai div bukan <a>, supaya bisa ada button di dalamnya --}}
            <div class="discussion-card" id="discussion-{{ $d->id }}">

                {{-- Header user --}}
                <div class="feed-card-header">
                    <a href="{{ route('profile.show', $d->user->username ?? $d->user->id) }}"
                       class="feed-user-avatar">
                        @if($d->user?->avatar)
                            <img loading="lazy" src="{{ asset('storage/'.$d->user->avatar) }}" alt="">
                        @else
                            {{ strtoupper(substr($d->user?->name ?? '?', 0, 1)) }}
                        @endif
                    </a>
                    <div class="feed-user-info">
                        <a href="{{ route('profile.show', $d->user->username ?? $d->user->id) }}"
                           class="feed-user-name">{{ $d->user?->name ?? 'User' }}</a>
                        <span class="feed-card-time">{{ $d->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Judul & preview body (klik ke detail) --}}
                <a href="{{ route('discussion.show', $d) }}" class="discussion-card-link">
                    <h3 class="discussion-card-title">{{ $d->title }}</h3>
                    <p class="discussion-card-preview">{{ Str::limit($d->body, 160) }}</p>
                </a>

                {{-- Aksi: Like + Balas --}}
                <div class="discussion-card-actions">
                    {{-- Like button --}}
                    @auth
                    <button class="btn-like-feed {{ $isLiked ? 'liked' : '' }}"
                            data-id="{{ $d->id }}"
                            data-url="{{ route('discussion.like', $d) }}">
                        <svg width="14" height="14" viewBox="0 0 24 24"
                             fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                             stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <span class="like-count">{{ $d->likes_count }}</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn-like-feed">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <span>{{ $d->likes_count }}</span>
                    </a>
                    @endauth

                    {{-- Toggle reply form --}}
                    @auth
                    <button class="btn-reply-feed" data-target="reply-box-{{ $d->id }}">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <span>{{ $d->replies_count }} Balas</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn-reply-feed">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <span>{{ $d->replies_count }} Balas</span>
                    </a>
                    @endauth

                    {{-- Lihat diskusi penuh --}}
                    <a href="{{ route('discussion.show', $d) }}" class="btn-view-full">
                        Lihat diskusi →
                    </a>
                </div>

                {{-- Preview replies (max 4) --}}
                @if($d->previewReplies->isNotEmpty())
                <div class="feed-replies-preview">
                    @foreach($d->previewReplies->reverse() as $reply)
                    <div class="feed-reply-item">
                        <a href="{{ route('profile.show', $reply->user->username ?? $reply->user->id) }}"
                           class="feed-reply-avatar">
                            @if($reply->user->avatar)
                                <img loading="lazy" src="{{ asset('storage/'.$reply->user->avatar) }}" alt="">
                            @else
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            @endif
                        </a>
                        <div class="feed-reply-content">
                            <a href="{{ route('profile.show', $reply->user->username ?? $reply->user->id) }}"
                               class="feed-reply-name">{{ $reply->user->name }}</a>
                            <span class="feed-reply-text">{{ Str::limit($reply->body, 120) }}</span>
                        </div>
                    </div>
                    @endforeach

                    {{-- See more jika replies > 4 --}}
                    @if($d->replies_count > 4)
                    <a href="{{ route('discussion.show', $d) }}" class="feed-see-more">
                        Lihat {{ $d->replies_count - 4 }} balasan lainnya →
                    </a>
                    @endif
                </div>
                @endif

                {{-- Inline reply form (hidden by default) --}}
                @auth
                <div class="feed-reply-form" id="reply-box-{{ $d->id }}" style="display:none">
                    <form method="POST" action="{{ route('discussion.reply', $d) }}">
                        @csrf
                        <div class="feed-reply-form-inner">
                            <div class="feed-user-avatar" style="width:28px;height:28px;font-size:0.6rem;flex-shrink:0">
                                @if(Auth::user()->avatar)
                                    <img loading="lazy" src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="">
                                @else
                                    {{ Auth::user()->avatar_letter }}
                                @endif
                            </div>
                            <textarea name="body" class="feed-reply-textarea"
                                      placeholder="Tulis balasanmu..."
                                      maxlength="2000" required></textarea>
                        </div>
                        <div class="feed-reply-submit-row">
                            <button type="button" class="btn-cancel-edit btn-reply-feed"
                                    data-target="reply-box-{{ $d->id }}">Batal</button>
                            <button type="submit" class="reply-submit-btn">Kirim</button>
                        </div>
                    </form>
                </div>
                @endauth

            </div>{{-- .discussion-card --}}
            @endforeach
        </div>

        <div style="margin-top:28px">
            {{ $discussions->appends(['tab' => 'discussions'])->links() }}
        </div>
        @endif

    {{-- ═══ TAB: KOLEKSI ═══ --}}
    @elseif($tab === 'collections')
        @if($collections->isEmpty())
            <div class="feed-empty">
                <div class="feed-empty-icon">🫧</div>
                <p>Belum ada koleksi publik.</p>
            </div>
        @else
        <div class="collections-grid">
            @foreach($collections as $col)
            <a href="{{ route('collections.show', $col) }}" class="collection-card">
                <div class="collection-card-previews">
                    @php $previews = $col->items->map(fn($i) => $i->product?->image_url)->filter()->take(3); @endphp
                    @forelse($previews as $img)
                        <div class="collection-preview-img"><img loading="lazy" src="{{ $img }}" alt=""></div>
                    @empty
                        <div class="collection-preview-empty">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                        </div>
                    @endforelse
                </div>
                <div class="collection-card-info">
                    <span class="collection-card-name">{{ $col->name }}</span>
                    <div class="collection-card-meta">
                        <span>
                            @if($col->user?->avatar)
                                <img loading="lazy" src="{{ asset('storage/'.$col->user->avatar) }}"
                                     style="width:13px;height:13px;border-radius:50%;object-fit:cover;vertical-align:middle;">
                            @endif
                            {{ $col->user?->name }}
                        </span>
                        <span>· {{ $col->items_count }} parfum</span>
                        <span>❤️ {{ $col->likes_count }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div style="margin-top:32px">
            {{ $collections->appends(['tab' => 'collections'])->links() }}
        </div>
        @endif
    @endif

</div>
@endsection

@push('scripts')
<script>
// ── Form diskusi baru ──
const openBtn   = document.getElementById('openNewDiscussion');
const box       = document.getElementById('newDiscussionBox');
const cancelBtn = document.getElementById('cancelDiscussion');
if (openBtn) openBtn.addEventListener('click', () => {
    box.style.display = box.style.display === 'none' ? 'block' : 'none';
    if (box.style.display === 'block') box.querySelector('input').focus();
});
if (cancelBtn) cancelBtn.addEventListener('click', () => box.style.display = 'none');
@if($errors->any()) if(box) box.style.display = 'block'; @endif

// ── Toggle reply form ──
document.querySelectorAll('.btn-reply-feed[data-target]').forEach(btn => {
    btn.addEventListener('click', () => {
        const form = document.getElementById(btn.dataset.target);
        if (!form) return;
        const isHidden = form.style.display === 'none';
        form.style.display = isHidden ? 'block' : 'none';
        if (isHidden) form.querySelector('textarea')?.focus();
    });
});

// ── Like AJAX ──
document.querySelectorAll('.btn-like-feed[data-id]').forEach(btn => {
    btn.addEventListener('click', async () => {
        try {
            const res  = await fetch(btn.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            });
            const data = await res.json();
            btn.querySelector('.like-count').textContent = data.count;
            btn.classList.toggle('liked', data.liked);
            btn.querySelector('svg').setAttribute('fill', data.liked ? 'currentColor' : 'none');
        } catch(e) {}
    });
});

// ── Auto scroll ke diskusi setelah reply ──
const hash = window.location.hash;
if (hash && hash.startsWith('#discussion-')) {
    const el = document.querySelector(hash);
    if (el) setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'center' }), 100);
}
</script>
@endpush
