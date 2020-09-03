@if ($paginator->hasPages())
    <div class="col">
        <ul class="pagination">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>&laquo;</li>
                <li>&lt;</li>
            @else
                <li><a href="{{ $paginator->path() . '?page=1' }}">&laquo;</a></li>
                <li><a href="{{ $paginator->previousPageUrl() }}">&lt;</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>{{ $element }}</li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active">{{ $page }}</li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a class="paginate-hover" href="{{ $paginator->nextPageUrl() }}">&gt;</a></li>
                <li><a class="paginate-hover" href="{{ $paginator->path() . '?page=' . $paginator->lastPage() }}">
                        &raquo;</a></li>
            @else
                <li>&gt;</li>
                <li>&raquo;</li>
            @endif
        </ul>
    </div>
@endif
