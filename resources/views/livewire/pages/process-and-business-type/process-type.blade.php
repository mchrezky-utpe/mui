<div
    class="tw-contents"
    x-data="{
        formMain: {
            id: null,
            prefix: null,
            manual_id: null,
            description: null,
            category: null,
            mst_sku_type_id: null,
        },
        isOpenMainModal: false,
        resetFormMain() {
            this.formMain = {
                id: null,
                prefix: null,
                manual_id: null,
                description: null,
                category: null,
                mst_sku_type_id: null,
            }
        },
        selectEditMainData(id) {
            if (!id) return;

            const mainData = $wire.cached_datas.data?.find(({ id: _id }) => id == _id);
            if (!mainData) return;

            this.formMain = {
                id: mainData.id,
                prefix: mainData.prefix,
                manual_id: mainData.manual_id,
                description: mainData.description,
                category: mainData.category,
                mst_sku_type_id: mainData.mst_sku_type_id
            }

            this.isOpenMainModal = true;
        },
        openMainModal() {
            this.isOpenMainModal = true;
            this.resetFormMain();
        },
        async removeMainData(id) {
            if (!id) return;

            const mainData = $wire.cached_datas.data?.find(({ id: _id }) => id == _id);
            if (!mainData) return;

            const { isConfirmed } = await Swal.fire({
                title: 'Yakin ingin hapus Data ini?',
                text: 'Data yang dihapus tidak bisa di kembalikan!',
                icon: 'warning',
                confirmButtonText: 'Ya, saya yakin!',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            });

            if (!isConfirmed) return;

            await $wire.remove(id)
        },
        async regeneratePrefix(id) {
            if (!id) return;

            const mainData = $wire.cached_datas.data?.find(({ id: _id }) => id == _id);
            if (!mainData) return;

            const { isConfirmed } = await Swal.fire({
                title: 'Confirm',
                text: 'Yakin ingin re-generate Code ini?',
                icon: 'warning',
                confirmButtonText: 'Ya, saya yakin!',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            });

            if (!isConfirmed) return;

            await $wire.regeneratePrefix(id)
        },
        init() {
            console.log('initial component.')
        }
    }"
>
    <div class="tw-px-2 tw-py-2 sm:tw-px-6 tw-grid tw-gap-6">
        <x-title-section title="SKU Process Type">
            <x-breadcrumbs :breadcrumbs="$breadcrumbs"></x-breadcrumbs>
        </x-title-section>

        <section
            id="main-content"
            class="tw-bg-white tw-rounded-md tw-shadow-sm"
        >
            <!-- Header -->
            <div
                class="tw-flex tw-items-center tw-justify-between tw-bg-black/5 tw-px-4 tw-py-2 tw-border-b"
            >
                <h5 class="tw-text-base tw-font-semibold tw-text-gray-800">
                    List
                </h5>

                <!-- <button
                    x-on:click="$dispatch('notify', { variant: 'info', title: 'Update Available', message: 'A new version of the app is ready for you. Update now to enjoy the latest features!' })"
                    type="button"
                    class="tw-whitespace-nowrap tw-rounded-sm tw-bg-sky-700 tw-px-4 tw-py-2 tw-text-center tw-text-sm tw-font-medium tw-tracking-wide tw-text-slate-100 tw-transition hover:tw-opacity-75 focus-visible:tw-outline-2 focus-visible:tw-outline-offset-2 focus-visible:tw-outline-sky-700 active:tw-opacity-100 active:tw-outline-offset-0 disabled:tw-cursor-not-allowed disabled:tw-opacity-75"
                >
                    Info
                </button> -->

                <!-- masih bootstrap, aman -->
                <button
                    class="btn btn-primary btn-sm"
                    x-on:click="openMainModal()"
                >
                    Add +
                </button>
            </div>

            <!-- Form Search -->
            <form wire:submit.prevent="resetPage" class="tw-px-4 tw-py-3">
                <div
                    class="tw-flex tw-flex-col tw-gap-3 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between"
                >
                    <!-- Show entries + sort -->
                    <div class="tw-flex tw-items-center tw-gap-2 tw-text-sm">
                        <span class="tw-text-gray-600">Show</span>

                        <select
                            wire:model="show_entry"
                            class="tw-h-9 tw-rounded-md tw-border tw-border-gray-300 tw-bg-white tw-px-2 tw-text-sm focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                        >
                            @foreach ($allowed_show_entries as $entry)
                            <option value="{{ $entry }}">{{ $entry }}</option>
                            @endforeach
                        </select>

                        <span class="tw-text-gray-600">entries</span>

                        <!-- Sort Desc -->
                        <select
                            wire:model="sort_desc"
                            class="tw-h-9 tw-rounded-md tw-border tw-border-gray-300 tw-bg-white tw-px-2 tw-text-sm focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                        >
                            <option value="true">
                                Sortir dari data terbaru
                            </option>
                            <option value="false">
                                Sortir dari data terlama
                            </option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div class="tw-relative tw-w-full sm:tw-w-64">
                        <div
                            class="tw-pointer-events-none tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3"
                        >
                            <svg
                                class="tw-h-4 tw-w-4 tw-text-gray-400"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>

                        <input
                            type="search"
                            id="table-search-users"
                            name="keyword"
                            wire:model="keyword"
                            autocomplete="off"
                            placeholder="Cari Data..."
                            class="tw-block tw-w-full tw-h-9 tw-rounded-md tw-border tw-border-gray-300 tw-bg-gray-50 tw-pl-10 tw-pr-3 tw-text-sm tw-text-gray-900 tw-placeholder-gray-400 focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                        />
                    </div>
                </div>
            </form>

            <!-- Table Wrapper -->
            <div
                class="tw-relative tw-overflow-x-auto tw-overflow-y-visible tw-border tw-border-gray-200 tw-rounded-md tw-m-2"
            >
                <!-- Overlay Spinner -->
                <div
                    wire:loading
                    wire:target="resetPage,addData,editData,deleteData"
                    class="tw-absolute tw-inset-0 tw-bg-white/70 tw-grid tw-place-content-center tw-place-items-center tw-z-10"
                >
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg
                            class="tw-w-6 tw-h-6 tw-animate-spin tw-text-gray-500"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <circle
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                                class="tw-opacity-25"
                            />
                            <path
                                d="M4 12a8 8 0 018-8"
                                stroke="currentColor"
                                stroke-width="4"
                                class="tw-opacity-75"
                            />
                        </svg>
                        <span class="tw-text-gray-500 tw-font-medium"
                            >Loading data...</span
                        >
                    </div>
                </div>

                <table
                    class="table-main tw-w-full tw-text-sm tw-text-left tw-border-collapse"
                >
                    <thead class="tw-bg-gray-100 tw-text-gray-700">
                        <tr>
                            <th
                                class="tw-px-3 tw-py-2 tw-font-semibold tw-w-12"
                            >
                                No
                            </th>
                            <th class="tw-px-3 tw-py-2 tw-font-semibold">
                                Code
                            </th>
                            <th class="tw-px-3 tw-py-2 tw-font-semibold">
                                Manual ID
                            </th>
                            <th class="tw-px-3 tw-py-2 tw-font-semibold">
                                Category
                            </th>
                            <th class="tw-px-3 tw-py-2 tw-font-semibold">
                                Name
                            </th>
                            <th class="tw-px-3 tw-py-2 tw-font-semibold">
                                Item Type
                            </th>
                            <th class="tw-px-3 tw-py-2 tw-font-semibold">
                                Extention
                            </th>
                            <th
                                class="tw-px-3 tw-py-2 tw-font-semibold tw-text-center tw-w-24"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="tw-divide-y tw-divide-gray-200">
                        @forelse ($main_datas as $main_data)
                        <tr class="tr">
                            <td class="tw-px-3 tw-py-2">
                                {{ $loop->index + 1 + $start_index }}
                            </td>
                            <td class="tw-px-3 tw-py-2 tw-font-medium">
                                {{ $main_data->prefix ?? "-" }}
                            </td>
                            <td class="tw-px-3 tw-py-2">
                                {{ $main_data->manual_id ?? "-" }}
                            </td>
                            <td class="tw-px-3 tw-py-2">
                                {{ $main_data->category ?? "-" }}
                            </td>
                            <td class="tw-px-3 tw-py-2">
                                {{ $main_data->description ?? "-" }}
                            </td>
                            <td class="tw-px-3 tw-py-2">
                                {{ $main_data->item_type->description ?? "-" }}
                            </td>
                            <td class="tw-px-3 tw-py-2">
                                {{ $main_data->item_type->prefix ?? "-" }}
                            </td>
                            <td class="tw-px-3 tw-py-2">
                                <div
                                    x-data="{ open: false }"
                                    class="tw-relative tw-flex tw-justify-center tw-isolate"
                                    @click.outside="open = false"
                                >
                                    <!-- Trigger (3 dots) -->
                                    <button
                                        type="button"
                                        @click="open = !open"
                                        class="tw-rounded tw-p-1.5 tw-text-gray-600 hover:tw-bg-gray-100 focus:tw-outline-none"
                                    >
                                        <!-- three dots icon -->
                                        <svg
                                            class="tw-w-5 tw-h-5 tw-rotate-90"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z"
                                            />
                                        </svg>
                                    </button>

                                    <!-- Dropdown -->
                                    <div
                                        x-show="open"
                                        x-transition
                                        x-cloak
                                        class="tw-absolute tw-right-0 tw-z-20 tw-mt-2 tw-w-40 tw-rounded-md tw-bg-white tw-shadow-lg tw-ring-1 tw-ring-black/5"
                                    >
                                        <ul class="tw-py-1 tw-text-sm">
                                            <!-- Edit -->
                                            <li>
                                                <button
                                                    type="button"
                                                    @click="
                                                            open = false;
                                                            selectEditMainData({{ $main_data->id }})
                                                        "
                                                    class="action-edit tw-flex tw-w-full tw-items-center tw-gap-2 tw-px-3 tw-py-2 tw-text-blue-600 hover:tw-bg-blue-100"
                                                >
                                                    <!-- icon (optional) -->
                                                    <svg
                                                        class="tw-h-4 tw-w-4"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <g
                                                            id="SVGRepo_bgCarrier"
                                                            stroke-width="0"
                                                        ></g>
                                                        <g
                                                            id="SVGRepo_tracerCarrier"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        ></g>
                                                        <g
                                                            id="SVGRepo_iconCarrier"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                clip-rule="evenodd"
                                                                d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z"
                                                                fill="currentColor"
                                                            ></path>
                                                        </g>
                                                    </svg>
                                                    <span>Edit</span>
                                                </button>
                                            </li>

                                            <!-- Delete -->
                                            <li>
                                                <button
                                                    type="button"
                                                    @click="
                                                            open = false;
                                                            removeMainData({{ $main_data->id }})
                                                        "
                                                    class="action-remove tw-flex tw-w-full tw-items-center tw-gap-2 tw-px-3 tw-py-2 hover:tw-bg-red-50 tw-text-red-600"
                                                >
                                                    <svg
                                                        class="tw-h-4 tw-w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m2-3h6a1 1 0 011 1v1H8V5a1 1 0 011-1z"
                                                        />
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </li>
                                            @if(!preg_match('/-/',$main_data->prefix??""))
                                            <li>
                                                <button
                                                    type="button"
                                                    @click="
                                                        open = false;
                                                        regeneratePrefix({{ $main_data->id }})
                                                    "
                                                    class="action-other tw-flex tw-w-full tw-items-center tw-gap-2 tw-px-3 tw-py-2 hover:tw-bg-gray-50"
                                                >
                                                    <span>Regenerate Code</span>
                                                </button>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td
                                colspan="6"
                                class="tw-py-6 tw-text-center tw-text-gray-500"
                            >
                                No data available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="tw-px-4 tw-py-3">
                {{ $main_datas->links('vendor.pagination.tw-custom') }}
            </div>
        </section>
    </div>

    <!-- Modal Overlay -->
    <div
        x-show="isOpenMainModal"
        x-cloak
        class="tw-fixed tw-inset-0 tw-z-50 tw-flex tw-items-center tw-justify-center"
    >
        <!-- Backdrop -->
        <div
            class="tw-absolute tw-inset-0 tw-bg-black/40"
            @click="isOpenMainModal = false"
            x-init="(console.log({ isOpenMainModal }), $watch('isOpenMainModal', () => console.log({ isOpenMainModal })), console.log({ isOpenMainModal }))"
        ></div>

        <!-- Modal Box -->
        <div
            x-show="isOpenMainModal"
            x-transition.scale
            class="tw-relative tw-w-full tw-max-w-md tw-rounded-lg tw-bg-white tw-shadow-lg"
        >
            <!-- Header -->
            <div
                class="tw-flex tw-items-center tw-justify-between tw-border-b tw-px-4 tw-py-3"
            >
                <h2
                    class="tw-text-lg tw-font-semibold tw-text-gray-800"
                    x-text="formMain.id ? 'Edit Data' : 'Tambah Data'"
                ></h2>

                <button
                    type="button"
                    @click="isOpenMainModal = false"
                    class="tw-text-gray-400 hover:tw-text-gray-600"
                >
                    ✕
                </button>
            </div>

            <!-- Body -->
            <form
                x-data="{ isSubmitting: false }"
                x-on:submit.prevent="
                    if (isSubmitting) return;   // jika lagi submit → ignore
                    isSubmitting = true;
                    $wire[formMain.id ? 'edit' : 'add'](formMain)
                        .then(() => {
                            isOpenMainModal = false;
                        })
                        .finally(() => {
                            isSubmitting = false;  // unlock form
                        });
                "
                class="tw-space-y-4 tw-p-4"
            >
                <!-- Code -->
                <div>
                    <label
                        class="tw-mb-1 tw-block tw-text-sm tw-font-medium tw-text-gray-600"
                    >
                        Code
                    </label>
                    <input
                        type="text"
                        x-model="formMain.prefix"
                        readonly
                        class="tw-w-full tw-rounded-md tw-border tw-border-gray-300 tw-bg-gray-100 tw-px-3 tw-py-2 tw-text-sm focus:tw-outline-none"
                        placeholder="PTC-XXXX"
                    />
                </div>

                <!-- Manual ID -->
                <div>
                    <label
                        class="tw-mb-1 tw-block tw-text-sm tw-font-medium tw-text-gray-600"
                    >
                        Manual ID
                    </label>
                    <input
                        type="text"
                        x-model="formMain.manual_id"
                        class="tw-w-full tw-rounded-md tw-border tw-border-slate-300 tw-ring-1 tw-ring-slate-300 tw-px-3 tw-py-2 tw-text-sm focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                        placeholder="(optional)"
                    />
                </div>

                <!-- Process Type -->
                <div>
                    <label
                        class="tw-mb-1 tw-block tw-text-sm tw-font-medium tw-text-gray-600"
                    >
                        Category
                    </label>
                    <select
                        x-model="formMain.category"
                        class="tw-w-full tw-rounded-md tw-border-slate-300 tw-ring-1 tw-ring-slate-300 tw-bg-white tw-px-3 tw-py-2 tw-text-sm focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                    >
                        <option value="">-- Pilih Category --</option>
                        <option value="IN-HOUSE">IN-HOUSE</option>
                        <option value="PURCHASE">PURCHASE</option>
                    </select>
                </div>

                <!-- Name -->
                <div>
                    <label
                        class="tw-mb-1 tw-block tw-text-sm tw-font-medium tw-text-gray-600"
                    >
                        Name
                    </label>
                    <input
                        type="text"
                        x-model="formMain.description"
                        class="tw-w-full tw-rounded-md tw-border-slate-300 tw-ring-1 tw-ring-slate-300 tw-px-3 tw-py-2 tw-text-sm focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                    />
                </div>

                <div>
                    <label
                        class="tw-mb-1 tw-block tw-text-sm tw-font-medium tw-text-gray-600"
                    >
                        Item Type
                    </label>
                    <select
                        x-model="formMain.mst_sku_type_id"
                        class="tw-w-full tw-rounded-md tw-border-slate-300 tw-ring-1 tw-ring-slate-300 tw-bg-white tw-px-3 tw-py-2 tw-text-sm focus:tw-border-blue-500 focus:tw-ring-1 focus:tw-ring-blue-500"
                    >
                        <option value="">-- Pilih Item Type --</option>
                        @foreach ($sku_types as $item_type)
                        <option value="{{ $item_type['id'] }}">
                            {{ $item_type["description"] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Footer -->
                <div class="tw-flex tw-justify-end tw-gap-2 tw-pt-2">
                    <button
                        type="button"
                        @click="isOpenMainModal = false"
                        class="tw-rounded-md tw-border-slate-300 tw-ring-1 tw-ring-slate-300 tw-px-4 tw-py-2 tw-text-sm tw-text-gray-600 hover:tw-bg-gray-100"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        x-bind:disabled="isSubmitting"
                        class="tw-relative tw-inline-flex tw-items-center tw-gap-2 tw-rounded-md tw-bg-blue-600 tw-px-4 tw-py-2 tw-text-sm tw-font-medium tw-text-white hover:tw-bg-blue-700"
                    >
                        <!-- Spinner Component -->
                        <x-loading-spinner
                            x-show="isSubmitting"
                            class="tw-w-4 tw-h-4"
                            text=""
                            svg_class="tw-text-white"
                        />

                        <!-- Button Text -->
                        <span x-text="(formMain.id ? 'Edit' : 'Tambah')"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
