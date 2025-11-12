@if ($paginator->hasPages())
    <ul class="pagination">

        {{-- First --}}
        @if (!$paginator->onFirstPage())
            <li><a href="{{ $paginator->url(1) }}">first</a></li>
        @else
            <li class="disabled"><span>first</span></li>
        @endif

        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>prev</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}">prev</a></li>
        @endif

        {{-- Page logic --}}
        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
        @endphp

        @for ($i = 1; $i <= $last; $i++)
            @if ($last <= 5)
                <li class="{{ $i == $current ? 'active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @elseif ($current <= 3)
                @if ($i <= 3)
                    <li class="{{ $i == $current ? 'active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @elseif ($current > 3 && $current < $last - 2)
                @if ($i == 1)
                    <li class="disabled"><span>...</span></li>
                @elseif ($i >= $current - 1 && $i <= $current + 1)
                    <li class="{{ $i == $current ? 'active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @elseif ($i == $last)
                    <li class="disabled"><span>...</span></li>
                @endif
            @elseif ($current >= $last - 2)
                @if ($i >= $last - 2)
                    <li class="{{ $i == $current ? 'active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endfor

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}">next</a></li>
        @else
            <li class="disabled"><span>next</span></li>
        @endif

        {{-- End --}}
        @if ($paginator->currentPage() < $paginator->lastPage())
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">end</a></li>
        @else
            <li class="disabled"><span>end</span></li>
        @endif
    </ul>
@endif
