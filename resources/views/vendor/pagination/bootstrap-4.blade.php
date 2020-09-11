@if ($paginator->hasPages())
    <div class="col">
        <ul class="pagination">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li><div class="disabled">&laquo;</div></li>
                <li><div class="disabled">&lt;</div></li>
            @else
                <li><a href="{{ $paginator->path() . '?page=1' }}"><div class="disabled">&laquo;</div></a></li>
                <li><a href="{{ $paginator->previousPageUrl() }}"><div class="disabled">&lt;</div></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><div class="disabled">{{ $element }}</div></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><div class="active">{{ $page }}</div></li>
                        @else
                            <li><a href="{{ $url }}"><div>{{ $page }}</div></a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}"><div>&gt;</div></a></li>
                <li><a href="{{ $paginator->path() . '?page=' . $paginator->lastPage() }}"><div>&raquo;</div></a></li>
            @else
                <li><div class="disabled">&gt;</div></li>
                <li><div class="disabled">&raquo;</div></li>
            @endif
        </ul>
    </div>
@endif
