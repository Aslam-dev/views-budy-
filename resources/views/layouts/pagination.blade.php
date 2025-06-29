@if ($paginator->hasPages())
    <ul class="pagination-list" data-aos="fade-up" data-aos-easing="linear">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="pagination-item disabled" aria-disabled="true">
                <span class="pagination-link" aria-hidden="true"><i class="page-chevron-left"></i></span>
            </li>
        @else
            <li class="pagination-item"><a class="pagination-link" href="{{ $paginator->previousPageUrl() }}"><i class="page-chevron-left"></i></a></li>
        @endif

        @if($paginator->currentPage() > 3)
            <li class="pagination-item hidden-xs"><a class="pagination-link" href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li class="pagination-item disabled" aria-disabled="true"><span class="pagination-link"><i class="bi bi-three-dots"></i></span></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="pagination-item active" aria-current="page"><span class="pagination-link">{{ $i }}</span></li>
                @else
                    <li class="pagination-item"><a class="pagination-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li class="pagination-item disabled" aria-disabled="true"><span class="pagination-link"><i class="bi bi-three-dots"></i></span></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="pagination-item"><a class="pagination-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="pagination-item">
                <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="page-chevron-right"></i></a>
            </li>
        @else
            <li class="pagination-item disabled" aria-disabled="true">
                <span class="pagination-link" aria-hidden="true"><i class="page-chevron-right"></i></span>
            </li>
        @endif
    </ul>

    <div data-aos="fade-up" data-aos-easing="linear">
        <p class="small text-muted">
            {!! __('Showing') !!}
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
@endif

