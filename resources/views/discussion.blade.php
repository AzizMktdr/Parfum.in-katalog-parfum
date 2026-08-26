@extends('layouts.app')

@section('title', $discussion->title . ' — Parfum.in')

@push('styles')
@endpush

@section('content')
<div class="community-page">

    {{-- Back --}}
    <a href="{{ route('community') }}" class="discussion-back">
        ← Kembali ke Community
    </a>

    {{-- ═══ POST UTAMA ═══ --}}
    <div class="discussion-post">
        {{-- Header user --}}
        <div class="feed-card-header">
            <a href="{{ route('profile.show', $discussion->user->username ?? $discussion->user->id) }}"
               class="feed-user-avatar">
                @if($discussion->user->avatar)
                    <img loading="lazy" src="{{ asset('storage/'.$discussion->user->avatar) }}" alt="">
                @else
                    {{ strtoupper(substr($discussion->user->name, 0, 1)) }}
                @endif
            </a>
            <div class="feed-user-info">
                <a href="{{ route('profile.show', $discussion->user->username ?? $discussion->user->id) }}"
                   class="feed-user-name">{{ $discussion->user->name }}</a>
                <span class="feed-card-time">{{ $discussion->created_at->diffForHumans() }}</span>
            </div>

            {{-- Hapus (hanya pemilik) --}}
            @auth
            @if(Auth::id() === $discussion->user_id)
            <form method="POST" action="{{ route('discussion.destroy', $discussion) }}"
                  style="margin-left:auto" onsubmit="return confirm('Hapus diskusi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete-reply">Hapus</button>
            </form>
            @endif
            @endauth
        </div>

        {{-- Konten --}}
        <h1 class="discussion-post-title">{{ $discussion->title }}</h1>
        <p class="discussion-post-body">{{ $discussion->body }}</p>

        {{-- Like button --}}
        <div class="discussion-post-actions">
            @auth
            <button class="btn-like-discussion {{ $isLiked ? 'liked' : '' }}"
                    id="likeBtn" data-id="{{ $discussion->id }}">
                <svg width="15" height="15" viewBox="0 0 24 24"
                     fill="{{ $isLiked ? 'currentColor' : 'none' }}"
                     stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span id="likeCount">{{ $discussion->likes_count }}</span>
            </button>
            @else
            <button class="btn-like-discussion" onclick="showLoginRequired('Login untuk memberi like.')">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                <span>{{ $discussion->likes_count }}</span>
            </button>
            @endauth

            <span class="discussion-reply-count">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                {{ $discussion->replies_count }} balasan
            </span>
        </div>
    </div>

    {{-- ═══ FORM REPLY UTAMA ═══ --}}
    @auth
    <div class="reply-form-wrap">
        <div class="feed-user-avatar" style="flex-shrink:0">
            @if(Auth::user()->avatar)
                <img loading="lazy" src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="">
            @else
                {{ Auth::user()->avatar_letter }}
            @endif
        </div>
        <form method="POST" action="{{ route('discussion.reply', $discussion) }}" class="reply-form">
            @csrf
            <textarea name="body" class="reply-textarea"
                      placeholder="Tulis balasanmu..." maxlength="2000" required></textarea>
            <div class="reply-form-footer">
                <button type="submit" class="reply-submit-btn">Kirim Balasan</button>
            </div>
        </form>
    </div>
    @else
    <div class="reply-login-prompt">
        <a href="{{ route('login') }}">Login</a> untuk ikut berdiskusi.
    </div>
    @endauth

    {{-- ═══ DAFTAR REPLIES ═══ --}}
    @if($discussion->replies->isNotEmpty())
    <div class="replies-section">
        <div class="replies-title">{{ $discussion->replies_count }} Balasan</div>

        @foreach($discussion->replies as $reply)
        <div class="reply-item" id="reply-{{ $reply->id }}">
            {{-- Header reply --}}
            <div class="reply-header">
                <a href="{{ route('profile.show', $reply->user->username ?? $reply->user->id) }}"
                   class="feed-user-avatar" style="width:28px;height:28px;font-size:0.62rem">
                    @if($reply->user->avatar)
                        <img loading="lazy" src="{{ asset('storage/'.$reply->user->avatar) }}" alt="">
                    @else
                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                    @endif
                </a>
                <div class="feed-user-info">
                    <a href="{{ route('profile.show', $reply->user->username ?? $reply->user->id) }}"
                       class="feed-user-name">{{ $reply->user->name }}</a>
                    <span class="feed-card-time">{{ $reply->created_at->diffForHumans() }}</span>
                </div>

                @auth
                <div class="reply-actions">
                    <button class="btn-reply-toggle" data-target="reply-form-{{ $reply->id }}">Balas</button>
                    @if(Auth::id() === $reply->user_id)
                    <form method="POST" action="{{ route('discussion.reply.destroy', $reply) }}"
                          onsubmit="return confirm('Hapus balasan ini?')" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-delete-reply">Hapus</button>
                    </form>
                    @endif
                </div>
                @endauth
            </div>

            {{-- Isi reply --}}
            <p class="reply-body">{{ $reply->body }}</p>

            {{-- Form reply ke reply (nested) --}}
            @auth
            <div class="nested-reply-form" id="reply-form-{{ $reply->id }}" style="display:none">
                <form method="POST" action="{{ route('discussion.reply', $discussion) }}">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                    <textarea name="body" class="reply-textarea reply-textarea-sm"
                              placeholder="Balas {{ $reply->user->name }}..."
                              maxlength="2000" required></textarea>
                    <div class="reply-form-footer">
                        <button type="button" class="btn-cancel-edit btn-reply-toggle"
                                data-target="reply-form-{{ $reply->id }}">Batal</button>
                        <button type="submit" class="reply-submit-btn">Kirim</button>
                    </div>
                </form>
            </div>
            @endauth

            {{-- Nested replies --}}
            @if($reply->children->isNotEmpty())
            <div class="nested-replies">
                @foreach($reply->children as $child)
                <div class="reply-item reply-item-nested" id="reply-{{ $child->id }}">
                    <div class="reply-header">
                        <a href="{{ route('profile.show', $child->user->username ?? $child->user->id) }}"
                           class="feed-user-avatar" style="width:24px;height:24px;font-size:0.58rem">
                            @if($child->user->avatar)
                                <img loading="lazy" src="{{ asset('storage/'.$child->user->avatar) }}" alt="">
                            @else
                                {{ strtoupper(substr($child->user->name, 0, 1)) }}
                            @endif
                        </a>
                        <div class="feed-user-info">
                            <a href="{{ route('profile.show', $child->user->username ?? $child->user->id) }}"
                               class="feed-user-name">{{ $child->user->name }}</a>
                            <span class="feed-card-time">{{ $child->created_at->diffForHumans() }}</span>
                        </div>
                        @auth
                        @if(Auth::id() === $child->user_id)
                        <form method="POST" action="{{ route('discussion.reply.destroy', $child) }}"
                              onsubmit="return confirm('Hapus balasan ini?')" style="display:inline;margin-left:auto">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete-reply">Hapus</button>
                        </form>
                        @endif
                        @endauth
                    </div>
                    <p class="reply-body">{{ $child->body }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
// Toggle nested reply forms
document.querySelectorAll('.btn-reply-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.dataset.target;
        const form = document.getElementById(targetId);
        if (!form) return;
        const isHidden = form.style.display === 'none';
        form.style.display = isHidden ? 'block' : 'none';
        if (isHidden) form.querySelector('textarea')?.focus();
    });
});

// Like button
const likeBtn = document.getElementById('likeBtn');
if (likeBtn) {
    likeBtn.addEventListener('click', async () => {
        try {
            const res = await fetch('{{ route("discussion.like", $discussion) }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': getCsrf(), 'Content-Type': 'application/json' },
            });
            const data = await res.json();
            document.getElementById('likeCount').textContent = data.count;
            likeBtn.classList.toggle('liked', data.liked);
            likeBtn.querySelector('svg').setAttribute('fill', data.liked ? 'currentColor' : 'none');
        } catch(e) {}
    });
}
</script>
@endpush
