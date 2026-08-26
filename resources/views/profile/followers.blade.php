@extends('layouts.app')

@section('title', ($type === 'followers' ? 'Followers' : 'Following') . ' — ' . $user->name)

@section('content')
<div class="profile-page" style="max-width:560px">

    <div class="followers-page-header">
        <a href="{{ route('profile.show', $user->username ?? $user->id) }}" class="followers-back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <div>
            <h1 class="followers-page-title">{{ $type === 'followers' ? 'Followers' : 'Following' }}</h1>
            <span class="followers-page-sub">{{ $user->name }}</span>
        </div>
    </div>

    <div class="followers-tabs">
        <a href="{{ route('profile.followers', $user->username ?? $user->id) }}"
           class="followers-tab {{ $type === 'followers' ? 'active' : '' }}">
            Followers ({{ $user->followers()->count() }})
        </a>
        <a href="{{ route('profile.following', $user->username ?? $user->id) }}"
           class="followers-tab {{ $type === 'following' ? 'active' : '' }}">
            Following ({{ $user->following()->count() }})
        </a>
    </div>

    <div class="followers-list">
        @forelse($list as $person)
        <div class="follower-item">
            <a href="{{ route('profile.show', $person->username ?? $person->id) }}" class="follower-item-info">
                <div class="follower-avatar">
                    @if($person->avatar)
                        <img src="{{ asset('storage/' . $person->avatar) }}" alt="">
                    @else
                        <span>{{ strtoupper(substr($person->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div>
                    <span class="follower-name">{{ $person->name }}</span>
                    @if($person->username)
                        <span class="follower-username">{{ '@'.$person->username }}</span>
                    @endif
                </div>
            </a>

            @auth
                @if(Auth::id() !== $person->id)
                @php $iFollowThem = Auth::user()->isFollowing($person); @endphp
                <button class="btn-follow-small {{ $iFollowThem ? 'following' : '' }}" data-id="{{ $person->id }}">
                    {{ $iFollowThem ? 'Mengikuti' : 'Follow' }}
                </button>
                @endif
            @endauth
        </div>
        @empty
        <p class="profile-empty">
            {{ $type === 'followers' ? 'Belum ada followers.' : 'Belum mengikuti siapa pun.' }}
        </p>
        @endforelse
    </div>

    @if($list->hasPages())
    <div style="margin-top:20px">{{ $list->links() }}</div>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-follow-small').forEach(btn => {
    btn.addEventListener('click', () => {
        fetch(`/follow/${btn.dataset.id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': getCsrf(), 'Accept': 'application/json' }
        })
        .then(async r => {
            const d = await r.json();
            if (r.status === 401 && d.require_login) { showLoginRequired('Login untuk mengikuti.'); return; }
            btn.classList.toggle('following', d.following);
            btn.textContent = d.following ? 'Mengikuti' : 'Follow';
        });
    });
});
</script>
@endpush
