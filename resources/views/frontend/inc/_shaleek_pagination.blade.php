@if ($paginator->hasPages())
    <div class="shaleek-pagination">
        @if ($paginator->onFirstPage())
            <span class="shaleek-page-btn disabled">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="shaleek-page-btn" rel="prev">‹</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="shaleek-page-btn disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="shaleek-page-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="shaleek-page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="shaleek-page-btn" rel="next">›</a>
        @else
            <span class="shaleek-page-btn disabled">›</span>
        @endif
    </div>
@endif
