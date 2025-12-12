document.addEventListener("DOMContentLoaded", async () => {
    const addButtonEl = document.querySelector("#add_button");
    // const addModalEl = document.querySelector("#add_modal");
    const addModalEl = $("#add_modal");

    addButtonEl.addEventListener("click", () => {
        console.log("prev modal");
        addModalEl.modal("show");
        // addModalEl.classList.add("show");
        console.log("after modal");
    });

    const selectInputItemTypeEl = $("#add_modal [name='mst_sku_type_id']");
    console.log("selectInputItemTypeEl", selectInputItemTypeEl);

    // $("#add_modal").on("click", () => {
    //     $("")
    // })

    // select input
    let itemType = [];

    (async () => {
        try {
            const fetched = await fetchedJson("/api/sku-type/name-n-extension");
            itemType = fetched?.data;

            console.log("fetched in itemType", fetched);
            console.log("itemType:", JSON.stringify(itemType, 0, 4));
            populateSelectV2(itemType, selectInputItemTypeEl);
        } catch (e) {
            console.error(e);
        }
    })();

    // if (itemType.length) {
    //     populateSelect(itemType, selectInputItemTypeEl);
    // } else console.warn("itemType is empty!!!");

    const table = new DataTable(".data-table-item", {
        scrollX: true,
        scrollY: "400px",
        scrollCollapse: true,
        fixedColumns: {
            left: 1,
            right: 1,
            heightMatch: "auto",
        },
        paging: true,
        pageLength: 10,
        responsive: false,
        columnDefs: [
            {
                targets: [0],
                className: "dtfc-fixed-left",
                orderable: false,
                searchable: false,
            },
            {
                targets: -1,
                className: "dtfc-fixed-right bg-light",
                orderable: false,
                searchable: false,
                width: "120px",
            },
            {
                targets: "_all",
                className: "text-nowrap bordered-cell",
            },
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/sku-process-type",
            type: "GET",
            dataSrc: "data", // PENTING!
        },

        columns: [
            // Index number
            {
                data: null,
                render: (data, type, row, meta) =>
                    meta.row + meta.settings._iDisplayStart + 1,
                className: "text-center",
                width: "50px",
            },

            { data: "code" },
            { data: "category" },
            { data: "name" },

            // Item type (nested object)
            {
                data: "item_type.description",
                defaultContent: "-",
            },
            {
                data: "item_type.prefix",
                defaultContent: "-",
                className: "text-center",
            },

            // Action
            {
                data: "id",
                orderable: false,
                searchable: false,
                className: "dtfc-fixed-right text-center",
                width: "120px",
                render: (id) => `
                    <div class="d-flex gap-1 justify-content-center">
                        <button data-id="${id}" type="button" class="edit btn btn-success btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                        </button>

                        <form action="/sku-part-information/${id}/delete" method="post">
                            <input type="hidden" name="_token" value="${
                                document.querySelector("input[name=_token]")
                                    .value
                            }">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                `,
            },
        ],

        _columns: [
            // No
            {
                data: null,
                render: (data, type, row, meta) => {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },

            // Image
            {
                data: "blob_image",
                render: (img) => {
                    if (img) {
                        return `<img src="data:image/png;base64,${img}" width="80"/>`;
                    }
                    return `<span class="text-muted">No image</span>`;
                },
            },

            // Part Code
            { data: "sku_id" },

            // Part Name
            { data: "sku_name" },

            // Spec Code
            { data: "sku_specification_code" },

            // Spec Description
            { data: "sku_specification_detail" },

            // Sales Category
            { data: "sku_sales_category" },

            // Set Code
            { data: "set_code" },

            // Item Sub Category
            { data: "sku_sub_category" },

            // Item Type
            { data: "sku_material_type" },

            // Business Type
            { data: "sku_business_type" },

            // Model
            { data: "sku_model" },

            // Surface Area
            { data: "val_area" },

            // Weight
            { data: "val_weight" },

            // Inventory Unit
            { data: "sku_inventory_unit" },

            // Procurement Type
            { data: "sku_procurement_type" },

            // Procurement Unit
            {
                data: "sku_procurement_unit",
                render: (v) => v ?? "-",
            },

            // Conversion value
            { data: "val_conversion" },

            // Inventory Register
            {
                data: "flag_inventory_register",
                render: (v) => (v == 1 ? "YES" : "NO"),
            },

            // Action button
            {
                data: "id",
                render: (id) => `
                    <div class="d-flex">
                        <button
                            data-id="${id}"
                            type="button"
                            class="edit btn btn-success"
                        >
                            <span class="fas fa-pencil-alt"></span>
                        </button>

                        <form action="/sku-part-information/${id}/delete" method="post">
                            <input type="hidden" name="_token"
                                value="${
                                    document.querySelector("input[name=_token]")
                                        .value
                                }">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">
                                <span class="fas fa-trash"></span>
                            </button>
                        </form>
                    </div>
                `,
            },
        ],
    });
});

const fetchedJson = async (uri, args) => {
    try {
        const fetched = await fetch(uri, args);

        const text = await fetched.text();

        let json;

        try {
            json = JSON.parse(text);
        } catch (e) {
            throw new Error(
                `request fetch '${uri}' was failed cuz the response is not valid json. response: ${text}`
            );
        }

        return json;
    } catch (e) {
        console.error(`Error while fetching, error: ${e}`);
    }
};

/**
 * fill select input option element.
 * note: element should be using jQuery :D
 */
const populateSelectV2 = (master_data, element) => {
    element.empty();
    element.append('<option value=""> -- Select -- </option>');
    master_data.forEach((data) => {
        element.append(
            `<option value="${data.id}">${data.description}</option>`
        );
    });
};
