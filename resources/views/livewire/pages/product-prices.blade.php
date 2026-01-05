<div
    class="tw-contents"
    x-data="{
        init() {
            console.log('initial component.')
        }
    }"
>
    <div class="tw-px-2 tw-py-2 sm:tw-px-6 tw-grid tw-gap-6">
        <x-title-section title="SKU Product Price">
            <x-breadcrumps :$breadcrumps></x-breadcrumps>
        </x-title-section>
    </div>
</div>
