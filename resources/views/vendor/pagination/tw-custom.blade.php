@if ($paginator->hasPages())
<nav
    role="navigation"
    aria-label="{{ __('Pagination Navigation') }}"
    class="tw-flex tw-items-center tw-justify-between"
>
    {{-- Mobile --}}
    <div class="tw-flex tw-justify-between tw-flex-1 sm:tw-hidden">
        @if ($paginator->onFirstPage())
        <span
            class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-500 tw-bg-white tw-border tw-border-gray-300 tw-cursor-default tw-leading-5 tw-rounded-md"
        >
            {!! __('pagination.previous') !!}
        </span>
        @else
        <a
            href="{{ $paginator->previousPageUrl() }}"
            class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 tw-leading-5 tw-rounded-md hover:tw-bg-gray-100"
        >
            {!! __('pagination.previous') !!}
        </a>
        @endif @if ($paginator->hasMorePages())
        <a
            href="{{ $paginator->nextPageUrl() }}"
            class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-ml-3 tw-text-sm tw-font-medium tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 tw-leading-5 tw-rounded-md hover:tw-bg-gray-100"
        >
            {!! __('pagination.next') !!}
        </a>
        @else
        <span
            class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-ml-3 tw-text-sm tw-font-medium tw-text-gray-500 tw-bg-white tw-border tw-border-gray-300 tw-cursor-default tw-leading-5 tw-rounded-md"
        >
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    {{-- Desktop --}}
    <div
        class="tw-hidden sm:tw-flex sm:tw-flex-1 sm:tw-items-center sm:tw-justify-between"
    >
        <div>
            <p class="tw-text-sm tw-text-gray-700">
                {!! __('Showing') !!}
                <span
                    class="tw-font-medium"
                    >{{ $paginator->firstItem() }}</span
                >
                {!! __('to') !!}
                <span class="tw-font-medium">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="tw-font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            @php $current = $paginator->currentPage(); $last =
            $paginator->lastPage(); $start = max(1, $current - 2); $end =
            min($last, $current + 2); if ($end - $start < 4) { if ($start === 1)
            { $end = min($last, 5); } elseif ($end === $last) { $start = max(1,
            $last - 4); } } @endphp

            <span
                class="tw-relative tw-z-0 tw-inline-flex tw-shadow-sm tw-rounded-md"
            >
                {{-- First --}}
                @if ($paginator->onFirstPage())
                <span
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300 tw-cursor-default"
                >
                    «
                </span>
                @else
                <a
                    href="{{ $paginator->url(1) }}"
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >
                    «
                </a>
                @endif

                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                <span
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300"
                >
                    ‹
                </span>
                @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >
                    ‹
                </a>
                @endif

                {{-- Pages (MAX 5, NO DOT) --}}
                @for ($page = $start; $page <= $end; $page++) @if ($page ==
                $current)
                <span
                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-bg-blue-600 tw-border tw-border-blue-600"
                >
                    {{ $page }}
                </span>
                @else
                <a
                    href="{{ $paginator->url($page) }}"
                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >
                    {{ $page }}
                </a>
                @endif @endfor

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >
                    ›
                </a>
                @else
                <span
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300"
                >
                    ›
                </span>
                @endif

                {{-- Last --}}
                @if ($paginator->currentPage() === $paginator->lastPage())
                <span
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300 tw-cursor-default"
                >
                    »
                </span>
                @else
                <a
                    href="{{ $paginator->url($last) }}"
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100"
                >
                    »
                </a>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
