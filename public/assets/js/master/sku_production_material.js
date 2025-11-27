document.addEventListener("DOMContentLoaded", () => {
    const csfr = document.querySelector("input[name=_token]").value;

    const table = new DataTable(".data-table-item", {
        scrollX: true,
        scrollY: "400px",
        scrollCollapse: true,
        fixedColumns: {
            left: 1,
            // left: 5
            // right: 1,
            heightMatch: "auto",
        },
        paging: true,
        pageLength: 10,
        responsive: false,
        columnDefs: [
            {
                targets: [0, 1, 2, 3, 4],
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
            url: "/api/sku-production-material",
            type: "GET",
        },

        columns: [
            // 1. No
            {
                data: null,
                render: (data, type, row, meta) => {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },

            // 2. Image
            {
                data: "blob_image",
                render: (data) => {
                    if (!data) {
                        return `<span class="text-muted">No image</span>`;
                    }
                    return `<img src="data:image/png;base64,${data}" width="80"/>`;
                },
            },

            // 3. Material Code
            { data: "sku_id" },

            // 4. Material Description
            { data: "sku_name" },

            // 5. Spec Code
            { data: "sku_specification_code" },

            // 6. Spec Description
            { data: "sku_specification_detail" },

            // 7. Sales Category
            { data: "sku_sales_category" },

            // 8. Set Code
            { data: "set_code" },

            // 9. Item Sub Category
            { data: "sku_sub_category" },

            // 10. Item Type
            { data: "sku_material_type" },

            // 11. Procurement Type
            { data: "sku_procurement_type" },

            // 12. Inventory Unit
            { data: "sku_inventory_unit" },

            // 13. Procurement Unit
            { data: "sku_procurement_unit" },

            // 14. Conversion Value
            { data: "val_conversion" },

            // 15. Inv. Reg (YES/NO)
            {
                data: "flag_inventory_register",
                render: (data) => (data == 1 ? "YES" : "NO"),
            },

            // 16. Action Button
            {
                data: null,
                orderable: false,
                searchable: false,
                render: (row) => `
                <form action="/sku-production-material/${row.id}/delete" method="post">
                    <input type="hidden" name="_token" value="${csfr}">
                    <div class="d-flex">

                        <button type="button"
                            data-id="${row.id}"
                            class="edit btn btn-success">
                            <span class="fas fa-pencil-alt"></span>
                        </button>

                        <button type="submit"
                            class="btn btn-danger">
                            <span class="fas fa-trash"></span>
                        </button>

                    </div>
                </form>
            `,
            },
        ],
    });
});

let isUselessModalAreRemovedAlready = false;

const removeUselessModal = () => {
    const m = document.querySelector(".modal-backdrop");
    if (m) {
        m.setAttribute("hidden", "");
        isUselessModalAreRemovedAlready = true;
    }

    console.warn("m", m);
};

// cache, biar kalau buka modal dengan data yang sama, gaperlu fetch lagi :D
// kalau reload bakal tetep fetch lagi sih D:
const cacheDetails = {};

const fillForm = (data) => {
    $("[name=id]").val(data.id);
    $("[name=manual_id]").val(data.manual_id);
    $("[name=description]").val(data.description);
    $("[name=group_tag]").val(data.group_tag);
    $("[name=specification_code]").val(data.specification_code);
    $("[name=specification_detail]").val(data.specification_detail);
    $("[name=specification_description]").val(data.specification_description);
    $("[name=val_weight]").val(data.val_weight);
    $("[name=val_area]").val(data.val_area);
    $("[name=sku_model_id]").val(data.sku_model_id);
    $("[name=val_conversion]").val(data.val_conversion);
    $("[name=flag_inventory_register]").val(data.flag_inventory_register);

    if (data.flag_inventory_register == 1) {
        $("[name=flag_inventory_register]").prop("checked", true);
    }

    $("[name=type_id]").val(data.sku_type_id).prop("selected", true);
    $("[name=model_id]").val(data.sku_model_id).prop("selected", true);
    $("[name=process_id]").val(data.sku_process_id).prop("selected", true);
    $("[name=sku_business_type_id]")
        .val(data.sku_business_type_id)
        .prop("selected", true);
    $("[name=sku_sales_category_id]")
        .val(data.sku_sales_category_id)
        .prop("selected", true);
    $("[name=sku_model_id]").val(data.sku_model_id).prop("selected", true);
    $("[name=sku_inventory_unit_id]")
        .val(data.sku_inventory_unit_id)
        .prop("selected", true);

    $("[name=flag_sku_procurement_type]")
        .val(data.flag_sku_procurement_type)
        .prop("selected", true);

    $("[name=sku_procurement_unit_id]")
        .val(data.sku_procurement_unit_id)
        .prop("selected", true);

    $("#edit_modal").modal("show");
    if (!isUselessModalAreRemovedAlready) removeUselessModal();
};

$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;

    const data = cacheDetails[id];
    if (data) return fillForm(data);

    $.ajax({
        type: "GET",
        url: base_url + "sku-production-material/" + id,
        success: function (_data) {
            const data = _data.data;

            fillForm(data);
            cacheDetails[id] = data;
        },
        error: function (err) {
            debugger;
        },
    });
});

$(document).on("click", ".history", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "sku-part-information/" + id + "/history",
        success: function (_data) {
            var data = _data.data;

            $("#history_modal").modal("show");
        },
        error: function (err) {
            debugger;
        },
    });
});

$(document).on("change", "[name=sku_type_id]", function () {
    const sku_type_id = this.value;
    fetchCode(sku_type_id)
        .then((data) => {
            $("[name=group_tag]").val(data.code);
            $("[name=manual_id]").val(data.code);
            $("[name=specification_code]").val(data.code);
            console.log("Succesfully fetchCode Sku:", data.sku);
        })
        .catch((err) => {
            console.error("Error get fetchCode:", err);
        });
});

function fetchCode(sku_type_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url:
                base_url +
                "api/sku-part-information/get-code?sku_type_id=" +
                sku_type_id +
                "&flag_sku_type=3",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetching code:", err);
                reject(err);
            },
        });
    });
}

function populateSelect(master_data, element) {
    element.empty();
    element.append('<option value=""> -- Select -- </option>');
    master_data.forEach((data) => {
        element.append(
            `<option value="${data.id}">${data.description}</option>`
        );
    });
}

// ================================

$(".btn_part_information").click(function () {
    fetchSetCode()
        .then((data) => {
            console.log("Succesfully fetchSetCode:", data);
            $("[name=group_tag]").val(data);
        })
        .catch((err) => {
            console.error("Error fetchSkuType:", err);
        });
});

fetchSkuType()
    .then((data) => {
        console.log("Succesfully fetchSkuType:", data);
        populateSelect(data, $("[name=sku_type_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuType:", err);
    });

function fetchSkuType() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-type/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuType:", err);
                reject(err);
            },
        });
    });
}
// ================================

// ================================
fetchSkuSalesCategory()
    .then((data) => {
        console.log("Succesfully fetchSkuSalesCategory:", data);
        populateSelect(data, $("[name=sku_sales_category_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuSalesCategory:", err);
    });

function fetchSkuSalesCategory() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-sales/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuSalesCategory:", err);
                reject(err);
            },
        });
    });
}
// ================================

// ================================
fetchSkuUnit()
    .then((data) => {
        console.log("Succesfully fetchSkuUnit:", data);
        populateSelect(data, $("[name=sku_procurement_unit_id]"));
        populateSelect(data, $("[name=sku_inventory_unit_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuUnit:", err);
    });

function fetchSkuUnit() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-unit/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuUnit:", err);
                reject(err);
            },
        });
    });
}
// ================================

// ================================
fetchSkuBusinessType()
    .then((data) => {
        console.log("Succesfully fetchSkuBusinessType:", data);
        populateSelect(data, $("[name=sku_category_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuBusinessType:", err);
    });

function fetchSkuBusinessType() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-business/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuBusinessType:", err);
                reject(err);
            },
        });
    });
}

// function fetchSkuItemType() {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             type: "GET",
//             url: base_url + "api/sku-type/droplist",
//             success: function (data) {
//                 resolve(data.data);
//             },
//             error: function (err) {
//                 console.error("Error fetchSkuType:", err);
//                 reject(err);
//             },
//         });
//     });
// }
// ================================

// ================================
fetchSkuModel()
    .then((data) => {
        console.log("Succesfully fetchSkuModel:", data);
        populateSelect(data, $("[name=sku_model_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuModel:", err);
    });

fetchSkuBusinessType()
    .then((data) => {
        console.log("Succesfully fetchSkuBusinessType:", data);
        populateSelect(data, $("[name=sku_business_type_id]"));
    })
    .catch((err) => {
        console.error("Error fetchSkuModel:", err);
    });

// fetchSkuItemType()
//     .then((data) => {
//         console.log("Succesfully fetchSkuItemType:", data);
//         populateSelect(data, $("[name=sku_item_type_id]"));
//     })
//     .catch((err) => {
//         console.error("Error fetchSkuModel:", err);
//     });

function fetchSkuModel() {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "GET",
            url: base_url + "api/sku-model/droplist",
            success: function (data) {
                resolve(data.data);
            },
            error: function (err) {
                console.error("Error fetchSkuModel:", err);
                reject(err);
            },
        });
    });
}

// function fetchSkuModel() {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             type: "GET",
//             url: base_url + "api/sku-business/droplist",
//             success: function (data) {
//                 resolve(data.data);
//             },
//             error: function (err) {
//                 console.error("Error fetchSkuModel:", err);
//                 reject(err);
//             },
//         });
//     });
// }

function fetchSetCode() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "/api/sku-part-information/get-set-code", // Endpoint backend
            method: "GET",
            success: function (response) {
                resolve(response[0].code);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    });
}
// ================================

// // Ketika input diklik, tampilkan modal
// $("[name=group_tag]").on("click", function () {
//     // Ambil data dari backend
//     $.ajax({
//         url: "/api/sku-part-information/get-set-code", // Endpoint backend
//         method: "GET",
//         success: function (response) {
//             var list = $("#setCodeList");
//             list.empty(); // Kosongkan list sebelum menambahkan data baru

//             // Tambahkan data ke dalam list
//             response.data.forEach(function (item) {
//                 list.append(
//                     '<li data-value="' + item.id + '">' + item.name + "</li>"
//                 );
//             });

//             $("#set_code_modal").modal("show");
//         },
//         error: function (xhr, status, error) {
//             console.error("Error fetching data:", error);
//         },
//     });
// });

// $("[name=group_tag]").on("click", function () {
//     // Ambil data dari backend
//     $.ajax({
//         url: "/api/sku-part-information/get-set-code", // Endpoint backend
//         method: "GET",
//         success: function (response) {
//             var list = $("#setCodeList");
//             list.empty(); // Kosongkan list sebelum menambahkan data baru

//             // Tambahkan data ke dalam list
//             response.forEach(function (item) {
//                 list.append(
//                     '<li data-value="' + item.code + '">' + item.code + "</li>"
//                 );
//             });

//             $("#set_code_modal").modal("show");
//         },
//         error: function (xhr, status, error) {
//             console.error("Error fetching data:", error);
//         },
//     });
// });
