@extends('layouts.app')

@section('title', 'Koleksi Saya — Parfum.in')

@section('content')
<div class="my-collections-page">
    <div class="my-collections-header">
        <h1 class="my-collections-title">Koleksi Saya</h1>
        <a href="{{ route('collections.create') }}" class="btn-new-collection">+ Buat Koleksi</a>
    </div>

    @if(session('success'))
        <div class="alert-success" style="margin-bottom:24px">{{ session('success') }}</div>
    @endif

    @if($collections->count() > 0)
    <div class="collections-grid">
        @foreach($collections as $col)
        <a href="{{ route('collections.show', $col) }}" class="collection-card">
            <div class="collection-card-previews">
                @php
                    // ✅ tanpa query baru: items sudah di-eager load di controller
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
                    <span>{{ $col->items_count }} parfum</span>
                    <span>❤️ {{ $col->likes_count }}</span>
                    <span>{{ $col->is_public ? '🌐 Publik' : '🔒 Privat' }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div style="text-align:center; padding: 60px 0;">
        <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:16px">Belum ada koleksi. Mulai buat koleksi parfum pertamamu!</p>
        <a href="{{ route('collections.create') }}" class="btn-new-collection">+ Buat Koleksi Pertama</a>
    </div>
    @endif
</div>
@endsection
