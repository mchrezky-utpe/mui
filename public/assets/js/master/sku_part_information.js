var table = new DataTable('.data-table-item',
    {
    scrollX: true,
    scrollY: "400px",
    scrollCollapse: true,
    fixedColumns: {
        left: 5, 
        right: 1,
        heightMatch: 'auto'
    },
    paging: true,
    pageLength: 10,
    responsive: false,
    columnDefs: [
        {
            targets: [0, 1, 2, 3, 4],
            className: 'dtfc-fixed-left',
            orderable: false,
            searchable: false
        },
        {
            targets: -1,
            className: 'dtfc-fixed-right bg-light',
            orderable: false,
            searchable: false,
            width: "120px"
        },
        {
            targets: '_all',
            className: 'text-nowrap bordered-cell' 
        }
    ]
});

$(document).on("click", ".edit", function (e) {
    var id = this.dataset.id;
    $.ajax({
        type: "GET",
        url: base_url + "sku-part-information/" + id,
        success: function (data) {
            var data = data.data;

            $("[name=id]").val(data.id);
            $("[name=manual_id]").val(data.manual_id);
            $("[name=description]").val(data.description);
            $("[name=group_tag]").val(data.group_tag);
            $("[name=specification_code]").val(data.specification_code);
            $("[name=specification_detail]").val(data.specification_detail);
            $("[name=val_weight]").val(Number(data.val_weight).toFixed());
            $("[name=val_area]").val(Number(data.val_area).toFixed());
            $("[name=sku_model_id]").val(data.sku_model_id);
            $("[name=val_conversion]").val(Number(data.val_conversion).toFixed());
            $("[name=flag_inventory_register]").val(
                data.flag_inventory_register
            );

            
            if(data.flag_inventory_register == 1){
               $("[name=flag_inventory_register]").prop('checked', true);
            }

            $("[name=type_id]").val(data.sku_type_id).prop("selected", true);
            $("[name=model_id]").val(data.sku_model_id).prop("selected", true);
            $("[name=process_id]")
                .val(data.sku_process_id)
                .prop("selected", true);
            $("[name=sku_business_type_id]")
                .val(data.sku_business_type_id)
                .prop("selected", true);
            $("[name=sku_sales_category_id]")
                .val(data.sku_sales_category_id)
                .prop("selected", true);
            $("[name=sku_model_id]")
                .val(data.sku_model_id)
                .prop("selected", true);
            $("[name=sku_inventory_unit_id]")
                .val(data.sku_inventory_unit_id)
                .prop("selected", true);
                
            $("[name=sku_type_id]")
                .val(data.sku_type_id)
                .prop("selected", true);
                
            $("[name=flag_sku_procurement_type]")
                .val(data.flag_sku_procurement_type)
                .prop("selected", true);

            if (data.flag_sku_type == 1) {
                $("#edit_modal").modal("show");
            }
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
        success: function (data) {
            var data = data.data;

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

$(".btn_part_information, .edit").click(function () {
    fetchSetCode()
        .then((data) => {
            console.log("Succesfully fetchSetCode:", data);
            var list = $("#setCodes");
            list.empty(); // Kosongkan list sebelum menambahkan data baru

            
            var listEdit = $("#setCodeEdit");
            listEdit.empty(); // Kosongkan list sebelum menambahkan data baru

            // Tambahkan data ke dalam list
            data.data.forEach(function (item) {
                list.append(
                     `<option value="`+item.code +`">`
                );
                listEdit.append(
                     `<option value="`+item.code +`">`
                );
            });
            $("[name=group_tag]").val(data.data[data.data.length-1].code);
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

function fetchSetCode() {
    return new Promise((resolve, reject) => {
          $.ajax({
        url: "/api/sku-part-information/get-set-code", // Endpoint backend
        method: "GET",
        success: function (response) {
      
                resolve(response);

            // $("#set_code_modal").modal("show");
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        },
        });
    });
}
// ================================

// Ketika input diklik, tampilkan modal
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
//             var list = $("#setCodes");
//             list.empty(); // Kosongkan list sebelum menambahkan data baru

//             // Tambahkan data ke dalam list
//             response.forEach(function (item) {
//                 list.append(
//                      `<option value="`+item.code +`">`
//                 );
//             });

//             // $("#set_code_modal").modal("show");
//         },
//         error: function (xhr, status, error) {
//             console.error("Error fetching data:", error);
//         },
//     });
// });
