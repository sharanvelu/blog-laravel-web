@if ($paginator->hasPages())
    <div class="row my-5">
        <div class="col text-center">
            <div class="block-27">
                <ul>
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="mr-2"><span class="paginate-disabled">&lt;</span></li>
                    @else
                        <li class="mr-2"><a href="{{ $paginator->previousPageUrl() }}" class="paginate-hover">&lt;</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="mr-2"><span class="paginate-disabled">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="mr-2 active"><span>{{ $page }}</span></li>
                                @else
                                    <li class="mr-2"><a class="paginate-hover" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li><a class="paginate-hover" href="{{ $paginator->nextPageUrl() }}">&gt;</a></li>
                    @else
                        <li><span class="paginate-disabled">&gt;</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
