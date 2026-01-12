@props(['title' => ''])

<section class="tw-grid tw-gap-1" id="title-section">
    <h2 class="tw-font-bold tw-text-xl sm:tw-text-2xl">
        {{ $title ?? "Title" }}
    </h2>

    {{ $slot }}

    <div class="tw-contents">
        @if ($errors->any())
        <ul class="tw-text-red-600 tw-text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>

    @if (session()->has('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 3000)"
        class="tw-mx-4 tw-mb-3 tw-flex tw-items-center tw-rounded-md tw-border tw-border-green-300 tw-bg-green-50 tw-px-4 tw-py-3 tw-text-sm tw-text-green-700"
    >
        <svg
            class="tw-mr-2 tw-h-4 tw-w-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
            />
        </svg>

        <span>{{ session("success") }}</span>

        <button
            @click="show = false"
            class="tw-ml-auto tw-text-green-700 hover:tw-text-green-900"
        >
            ✕
        </button>
    </div>
    @endif
</section>
