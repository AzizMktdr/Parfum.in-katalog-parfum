@extends('layouts.app')
@section('title', 'Favorit Saya — Parfum.in')
@section('content')

<div class="favorites-page">
    <h1 class="favorites-title">Favorit Saya</h1>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($favorites->isEmpty())
    <div class="favorites-empty">
        <div class="favorites-empty-icon">🤍</div>
        <p>Belum ada parfum yang disimpan.</p>
        <a href="{{ route('fragrances.index') }}" class="btn-outline-sm">Jelajahi Fragrances</a>
    </div>
    @else
    <div class="favorites-grid">
        @foreach($favorites as $fav)
        <div class="fav-item-card">
            <a href="{{ route('product.detail', $fav->product_slug) }}" class="fav-item-img-wrap">
                <img src="{{ asset($fav->product_image) }}" alt="{{ $fav->product_name }}" onerror="this.style.opacity='0.15'">
            </a>
            <div class="fav-item-info">
                <a href="{{ route('product.detail', $fav->product_slug) }}" class="fav-item-name">{{ $fav->product_name }}</a>
                <span class="fav-item-brand">{{ $fav->product_brand }}</span>
            </div>
            <form method="POST" action="{{ route('favorites.destroy', $fav->product_slug) }}" class="fav-item-remove">
                @csrf @method('DELETE')
                <button type="submit" class="fav-remove-btn" title="Hapus dari favorit">×</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif
</div>

@include('partials.footer')
@endsection
