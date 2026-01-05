@if ($paginator->hasPages())
<nav
    role="navigation"
    aria-label="Pagination Navigation"
    class="tw-flex tw-items-center tw-justify-between"
>
    <div>
        <p class="tw-text-sm tw-text-gray-700 tw-leading-5">
            Showing @if ($paginator->firstItem())
            <span class="tw-font-medium">{{ $paginator->firstItem() }}</span>
            to
            <span class="tw-font-medium">{{ $paginator->lastItem() }}</span>
            @else
            {{ $paginator->count() }}
            @endif of
            <span class="tw-font-medium">{{ $paginator->total() }}</span>
            results
        </p>
    </div>

    <div>
        <span
            class="tw-relative tw-z-0 tw-inline-flex tw-shadow-sm tw-rounded-md"
        >
            {{-- First --}}
            @if ($paginator->onFirstPage())
            <span
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300 tw-rounded-l-md"
                >«</span
            >
            @else
            <a
                href="{{ $paginator->url(1) }}"
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 tw-rounded-l-md hover:tw-bg-gray-100"
                >«</a
            >
            @endif

            {{-- Prev --}}
            @if ($paginator->onFirstPage())
            <span
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300"
                >‹</span
            >
            @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >‹</a
            >
            @endif

            {{-- Pages (MAX 5) --}}
            @php $current = $paginator->currentPage(); $last =
            $paginator->lastPage(); $start = max($current - 2, 1); $end =
            min($start + 4, $last); $start = max($end - 4, 1); @endphp
            @for($page = $start; $page <= $end; $page++) @if ($page == $current)
            <span
                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-bg-blue-600 tw-border tw-border-blue-600"
                >{{ $page }}</span
            >
            @else
            <a
                href="{{ $paginator->url($page) }}"
                class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >{{ $page }}</a
            >
            @endif @endfor

            {{-- Next --}}
            @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >›</a
            >
            @else
            <span
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300"
                >›</span
            >
            @endif

            {{-- Last --}}
            @if ($paginator->currentPage() == $paginator->lastPage())
            <span
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300 tw-rounded-r-md"
                >»</span
            >
            @else
            <a
                href="{{ $paginator->url($last) }}"
                class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 tw-rounded-r-md hover:tw-bg-gray-100"
                >»</a
            >
            @endif
        </span>
    </div>
</nav>
@endif
