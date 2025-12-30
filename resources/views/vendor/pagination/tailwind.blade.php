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
            class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 tw-leading-5 tw-rounded-md hover:tw-text-gray-500 focus:tw-outline-none focus:tw-ring focus:tw-ring-gray-300 focus:tw-border-blue-300 active:tw-bg-gray-100 active:tw-text-gray-700 tw-transition"
        >
            {!! __('pagination.previous') !!}
        </a>
        @endif @if ($paginator->hasMorePages())
        <a
            href="{{ $paginator->nextPageUrl() }}"
            class="tw-relative tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-ml-3 tw-text-sm tw-font-medium tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 tw-leading-5 tw-rounded-md hover:tw-text-gray-500 focus:tw-outline-none focus:tw-ring focus:tw-ring-gray-300 focus:tw-border-blue-300 active:tw-bg-gray-100 active:tw-text-gray-700 tw-transition"
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
            <p class="tw-text-sm tw-text-gray-700 tw-leading-5">
                {!! __('Showing') !!} @if ($paginator->firstItem())
                <span
                    class="tw-font-medium"
                    >{{ $paginator->firstItem() }}</span
                >
                {!! __('to') !!}
                <span class="tw-font-medium">{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif {!! __('of') !!}
                <span class="tw-font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span
                class="tw-relative tw-z-0 tw-inline-flex tw-shadow-sm tw-rounded-md"
            >
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                <span
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300 tw-rounded-l-md"
                >
                    ‹
                </span>
                @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 tw-rounded-l-md hover:tw-bg-gray-100 focus:tw-ring"
                >
                    ‹
                </a>
                @endif

                {{-- Pages --}}
                @foreach ($elements as $element) @if (is_string($element))
                <span
                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-text-gray-500 tw-bg-white tw-border tw-border-gray-300"
                >
                    {{ $element }}
                </span>
                @endif @if (is_array($element)) @foreach ($element as $page =>
                $url) @if ($page == $paginator->currentPage())
                <span
                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white tw-bg-blue-600 tw-border tw-border-blue-600"
                >
                    {{ $page }}
                </span>
                @else
                <a
                    href="{{ $url }}"
                    class="tw-inline-flex tw-items-center tw-px-4 tw-py-2 tw-text-sm tw-text-gray-700 tw-bg-white tw-border tw-border-gray-300 hover:tw-bg-gray-100 focus:tw-ring"
                >
                    {{ $page }}
                </a>
                @endif @endforeach @endif @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-600 tw-bg-white tw-border tw-border-gray-300 tw-rounded-r-md hover:tw-bg-gray-100 focus:tw-ring"
                >
                    ›
                </a>
                @else
                <span
                    class="tw-inline-flex tw-items-center tw-px-2 tw-py-2 tw-text-sm tw-text-gray-400 tw-bg-white tw-border tw-border-gray-300 tw-rounded-r-md"
                >
                    ›
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif
