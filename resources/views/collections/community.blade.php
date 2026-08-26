@extends('layouts.app')

@section('title', 'Community — Parfum.in')

@section('content')
<div class="my-collections-page">
    <div class="my-collections-header">
        <h1 class="my-collections-title">Community Collections</h1>
    </div>

    <div class="collections-grid">
        @foreach($collections as $col)
        <a href="{{ route('collections.show', $col) }}" class="collection-card">
            <div class="collection-card-previews">
                @php
                    $previews = $col->items->take(3)->map(fn($i) => $i->product?->image_url)->filter();
                @endphp
                @forelse($previews as $img)
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
                    {{-- Nama user bisa diklik --}}
                    <a href="{{ route('profile.show', $col->user->username ?? $col->user->id) }}"
                       onclick="event.preventDefault(); event.stopPropagation(); window.location='{{ route('profile.show', $col->user->username ?? $col->user->id) }}';"
                       style="font-size:0.58rem; color:var(--text-muted); text-decoration:none;">
                        @if($col->user->avatar)
                            <img src="{{ asset('storage/'.$col->user->avatar) }}"
                                 style="width:14px;height:14px;border-radius:50%;object-fit:cover;vertical-align:middle;margin-right:3px;">
                        @endif
                        {{ $col->user->name }}
                    </a>
                    <span>· {{ $col->items_count }} parfum</span>
                    <span>❤️ {{ $col->likes_count }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div style="margin-top:32px">
        {{ $collections->links() }}
    </div>
</div>
@endsection