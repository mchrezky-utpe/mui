$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "sku-process/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=manual_id]").val(data.manual_id);
            $("[name=description]").val(data.description);

            $("#edit_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const csfr = document.querySelector("input[name=_token]").value;

    alert("hai");
    console.warn("haloo");

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
        },

        columns: [
            {
                data: null,
                render: (data, type, row, meta) => {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: "code",
            },
            {
                data: "code_seq",
            },
            {
                data: "name",
            },
        ],

        // columns: [
        //     // No
        //     {
        //         data: null,
        //         render: (data, type, row, meta) => {
        //             return meta.row + meta.settings._iDisplayStart + 1;
        //         },
        //     },

        //     // Image
        //     {
        //         data: "blob_image",
        //         render: (img) => {
        //             if (img) {
        //                 return `<img src="data:image/png;base64,${img}" width="80"/>`;
        //             }
        //             return `<span class="text-muted">No image</span>`;
        //         },
        //     },

        //     // Part Code
        //     { data: "sku_id" },

        //     // Part Name
        //     { data: "sku_name" },

        //     // Spec Code
        //     { data: "sku_specification_code" },

        //     // Spec Description
        //     { data: "sku_specification_detail" },

        //     // Sales Category
        //     { data: "sku_sales_category" },

        //     // Set Code
        //     { data: "set_code" },

        //     // Item Sub Category
        //     { data: "sku_sub_category" },

        //     // Item Type
        //     { data: "sku_material_type" },

        //     // Business Type
        //     { data: "sku_business_type" },

        //     // Model
        //     { data: "sku_model" },

        //     // Surface Area
        //     { data: "val_area" },

        //     // Weight
        //     { data: "val_weight" },

        //     // Inventory Unit
        //     { data: "sku_inventory_unit" },

        //     // Procurement Type
        //     { data: "sku_procurement_type" },

        //     // Procurement Unit
        //     {
        //         data: "sku_procurement_unit",
        //         render: (v) => v ?? "-",
        //     },

        //     // Conversion value
        //     { data: "val_conversion" },

        //     // Inventory Register
        //     {
        //         data: "flag_inventory_register",
        //         render: (v) => (v == 1 ? "YES" : "NO"),
        //     },

        //     // Action button
        //     {
        //         data: "id",
        //         render: (id) => `
        //             <div class="d-flex">
        //                 <button
        //                     data-id="${id}"
        //                     type="button"
        //                     class="edit btn btn-success"
        //                 >
        //                     <span class="fas fa-pencil-alt"></span>
        //                 </button>

        //                 <form action="/sku-part-information/${id}/delete" method="post">
        //                     <input type="hidden" name="_token"
        //                         value="${
        //                             document.querySelector("input[name=_token]")
        //                                 .value
        //                         }">
        //                     <input type="hidden" name="_method" value="DELETE">
        //                     <button type="submit" class="btn btn-danger">
        //                         <span class="fas fa-trash"></span>
        //                     </button>
        //                 </form>
        //             </div>
        //         `,
        //     },
        // ],
    });

    console.log("table", table);
});
