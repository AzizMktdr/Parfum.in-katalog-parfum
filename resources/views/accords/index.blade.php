@extends('layouts.app')
@section('title', 'Accords — Parfum.in')
@section('content')

<div class="simple-page">
    <h1 class="simple-page-title">Accords</h1>

    <div class="list-table">
        @foreach($accords as $accord)
        <a href="{{ route('accords.show', $accord['slug']) }}" class="list-row">
            <span class="list-row-name">{{ $accord['name'] }}</span>
            <span class="list-row-arrow">›</span>
        </a>
        @endforeach
    </div>
</div>

@include('partials.footer')
@endsection
