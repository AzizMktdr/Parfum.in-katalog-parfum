{{--
    Reusable heading: serif title + gold divider with sparkle, same style as Community page.
    Usage: @include('partials.section-heading', ['title' => 'Fragrances', 'subtitle' => 'Optional subtitle text'])
--}}
<div class="section-heading">
    <h1 class="section-heading-title">{{ $title }}</h1>
    <div class="section-heading-divider">
        <span></span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0l2.2 9.8L24 12l-9.8 2.2L12 24l-2.2-9.8L0 12l9.8-2.2z"/></svg>
        <span></span>
    </div>
    @isset($subtitle)
    <p class="section-heading-subtitle">{{ $subtitle }}</p>
    @endisset
</div>
