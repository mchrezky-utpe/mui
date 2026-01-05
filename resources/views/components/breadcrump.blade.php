<nav aria-label="breadcrumb">
    <ol
        class="tw-flex tw-flex-wrap tw-items-center tw-gap-1 tw-p-3 tw-text-xs tw-text-gray-500 tw-bg-[rgba(233,236,239)]"
    >
        @foreach($breadcrumbs as $bread => $link) @if(!$loop->last)
        <li>
            <a
                href="{{ $link ?? '#' }}"
                class="tw-text-blue-600 hover:tw-text-blue-700 hover:tw-underline"
            >
                {{ $bread ?? "" }}
            </a>
        </li>

        <li class="tw-text-gray-400">/</li>
        @else
        <li class="tw-text-gray-600 tw-font-medium" aria-current="page">
            {{ $bread }}
        </li>
        @endif @endforeach
    </ol>
    <!-- <ol
        class="tw-flex tw-flex-wrap tw-items-center tw-gap-1 tw-p-3 tw-text-xs tw-text-gray-500 tw-bg-[rgba(233,236,239)]"
    >
        <li>
            <a
                href="#"
                class="tw-text-blue-600 hover:tw-text-blue-700 hover:tw-underline"
            >
                Master
            </a>
        </li>

        <li class="tw-text-gray-400">/</li>

        <li>
            <a
                href="#"
                class="tw-text-blue-600 hover:tw-text-blue-700 hover:tw-underline"
            >
                SKU
            </a>
        </li>

        <li class="tw-text-gray-400">/</li>

        <li class="tw-text-gray-600 tw-font-medium" aria-current="page">
            Business Type
        </li>
    </ol> -->
</nav>
