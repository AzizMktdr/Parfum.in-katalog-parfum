@extends('layouts.app')
@section('title', 'All Brands — Parfum.in')
@section('content')

<div class="simple-page">
    <h1 class="simple-page-title">All Brands</h1>

    <div class="list-table">
        @foreach($brands as $brand)
        <a href="{{ route('brands.show', $brand['slug']) }}" class="list-row">
            <span class="list-row-name">{{ $brand['name'] }}</span>
            <span class="list-row-arrow">›</span>
        </a>
        @endforeach
    </div>
</div>

@include('partials.footer')
@endsection
