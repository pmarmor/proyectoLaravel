@if ($paginator->hasPages())
    <nav class="paginationNav">
        <div>
            <div>
                <p>
                    {{'Mostrando desde'}}
                    <span class="">{{ $paginator->firstItem() }}</span>
                    {{'hasta'}}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {{'de'}}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('usuarios en total') !!}
                </p>
            </div>

            <div>
                <ul class="paginationList">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span aria-hidden="true" class="arrow">&lsaquo;</span>
                        </li>
                    @else
                        <li >
                            <a class="paginationArrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif
<script>
    let array= @json($elements);
    console.log(array);
</script>
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li aria-current="page" class="currentPage pageLinks" ><span>{{ $page }}</span></li>
                                @else
                                    <li class="pageLinks"><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a class="paginationArrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li aria-disabled="true" aria-label="@lang('pagination.next')" class="arrow">
                            <span aria-hidden="true" >&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
