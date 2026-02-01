document.addEventListener("DOMContentLoaded", function () {
    const customer = $("#customer");
    const customer_sales_order_details = $("#customer_sales_order_details");
    const currency = $("#currency");
    const typeItem = $("#type_item");
    const rate = document.getElementById("exchange_rate");
    const validFrom = document.getElementById("valid_from");
    const validUntil = document.getElementById("valid_until");
    const validFromSalesOrderDetails = document.getElementById(
        "valid_from_sales_order_details",
    );
    const validUntilSalesOrderDetails = document.getElementById(
        "valid_until_sales_order_details",
    );

    let lastCustomer = null;
    let allowChange = true;

    $("#customer").on("select2:selecting", function (e) {
        if (!allowChange) return;

        const newCustomer = e.params.args.data.id;

        if (selectedItems.length === 0) {
            lastCustomer = newCustomer;
            return;
        }

        e.preventDefault();

        Swal.fire({
            title: "Ganti Customer?",
            text: "Item yang sudah dipilih akan dihapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, ganti",
            cancelButtonText: "Batal",
        }).then((res) => {
            if (res.isConfirmed) {
                allowChange = false;

                selectedItems = [];
                tableSelected.clear().draw();

                $("#customer").val(newCustomer).trigger("change");

                lastCustomer = newCustomer;

                allowChange = true;
            }
        });
    });

    validFrom.addEventListener("change", function () {
        validUntil.min = this.value;
        if (validUntil.value < this.value) {
            validUntil.value = this.value;
        }
    });

    validFromSalesOrderDetails.addEventListener("change", function () {
        validUntilSalesOrderDetails.disabled = false;
        validUntilSalesOrderDetails.min = this.value;
        if (validUntilSalesOrderDetails.value < this.value) {
            validUntilSalesOrderDetails.value = this.value;
        }
    });

    $.ajax({
        url: base_url + "api/sales_order/droplist-list-customer",
        type: "GET",
        dataType: "json",
        success: function (res) {
            if (res.status) {
                customer
                    .empty()
                    .append('<option value="">-- Select Customer --</option>');

                customer_sales_order_details
                    .empty()
                    .append('<option value="">-- Select Customer --</option>');

                res.data.forEach((item) => {
                    customer.append(
                        `<option value="${item.id}">${item.name}</option>`,
                    );

                    customer_sales_order_details.append(
                        `<option value="${item.id}">${item.name}</option>`,
                    );
                });

                customer.select2({
                    placeholder: "Select Customer",
                    width: "100%",
                });

                customer_sales_order_details.select2({
                    placeholder: "Select Customer",
                    width: "100%",
                });
            }
        },
    });

    $.ajax({
        url: base_url + "api/sales_order/droplist-list-currency",
        type: "GET",
        dataType: "json",
        success: function (res) {
            if (res.status) {
                currency
                    .empty()
                    .append('<option value="">-- Select Currency --</option>');

                res.data.forEach((item) => {
                    currency.append(
                        `<option value="${item.prefix}">${item.prefix}</option>`,
                    );
                });

                currency.select2({
                    placeholder: "Select Currency",
                    width: "100%",
                });
            }
        },
    });

    $.ajax({
        url: base_url + "api/sales_order/droplist-list-category",
        type: "GET",
        dataType: "json",
        success: function (res) {
            if (res.status) {
                typeItem
                    .empty()
                    .append('<option value="">-- Select Type Item --</option>');

                res.data.forEach((item) => {
                    typeItem.append(
                        `<option value="${item.description}">${item.description}</option>`,
                    );
                });

                typeItem.select2({
                    placeholder: "Select Type Item",
                    width: "100%",
                });
            }
        },
    });

    currency.on("change", function () {
        if (this.value === "IDR") {
            rate.value = 1;
            rate.readOnly = true;
        } else {
            rate.value = "";
            rate.readOnly = false;
        }
    });

    rate.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9,]/g, "");
    });

    //load datatable
    let tableProductPricelist = null;
    let tableSalesOrderlist = null;
    let tableDetailSO = null;

    function isFilterFilled() {
        return (
            $("#customer").val() &&
            $("#valid_from").val() &&
            $("#valid_until").val() &&
            $("#type_item").val()
        );
    }

    function initTableProductPricelist() {
        if (tableProductPricelist) return;

        tableProductPricelist = $("#table_product_pricelist").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            responsive: true,
            searching: true,

            dom:
                "<'row mb-2'<'col-md-6'l><'col-md-6 text-right'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",

            ajax: {
                url: base_url + "api/sales_order/droplist-product-pricelist",
                type: "GET",

                data: function (d) {
                    d.customer = $("#customer").val();
                    d.valid_from = $("#valid_from").val();
                    d.valid_until = $("#valid_until").val();
                    d.type_item = $("#type_item").val();
                },

                dataSrc: function (json) {
                    if (!isFilterFilled()) {
                        json.recordsTotal = 0;
                        json.recordsFiltered = 0;
                        return [];
                    }

                    return json.data;
                },
            },

            columns: [
                { data: "sku_id" },
                { data: "sku_name" },
                { data: "sku_specification_code" },
                { data: null, defaultContent: "-" },
                { data: null, defaultContent: "-" },
                { data: "sku_inventory_unit", className: "text-center" },
                { data: "currency", className: "text-center" },
                {
                    data: "price",
                    className: "text-right",
                    render: (d) => new Intl.NumberFormat("id-ID").format(d),
                },
                { data: "valid_date_from", className: "text-center" },
                { data: "valid_date_to", className: "text-center" },
                {
                    data: "pricelist_status",
                    className: "text-center",
                    render: (d) =>
                        d === "ACTIVE"
                            ? `<span class="badge badge-success">ACTIVE</span>`
                            : `<span class="badge badge-danger">INACTIVE</span>`,
                },
            ],

            language: {
                processing: `
                <div class="dt-loading-wrapper">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2">Loading data...</div>
                </div>
            `,
            },
        });
    }

    function initTableSalesOrderlist() {
        if (tableSalesOrderlist) return;

        tableSalesOrderlist = $("#table_sales_order").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            responsive: true,

            dom:
                "<'row mb-2'<'col-md-6'l><'col-md-6 text-right'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",

            ajax: {
                url: base_url + "api/sales_order/droplist-sales-order-list",
                type: "GET",
                data: function (d) {
                    d.customer_sales_order_details = $(
                        "[name=customer_sales_order_details]",
                    ).val();
                    d.valid_from_sales_order_details = $(
                        "[name=valid_from_sales_order_details]",
                    ).val();
                    d.valid_until_sales_order_details = $(
                        "[name=valid_until_sales_order_details]",
                    ).val();
                },
            },

            columns: [
                { data: "so_number" },
                { data: "so_date" },
                { data: "po_number" },
                { data: "ref_number" },
                { data: "customer_name" },
                { data: "valid_from" },
                { data: "valid_until" },
                { data: "validation_status" },
                {
                    data: "so_status",
                    className: "text-center",
                    render: (data) =>
                        data === 1
                            ? `<span class="badge badge-success">&nbsp;</span>`
                            : `<span class="badge badge-danger">&nbsp;</span>`,
                },
                {
                    data: "id",
                    render: function (data, type, row) {
                        return `
                    <button 
                        class="btn btn-sm btn-primary btn-detail-so"
                        data-id="${row.id}"
                        data-so="${row.so_number}"
                    >
                        Detail
                    </button>
                `;
                    },
                    orderable: false,
                    searchable: false,
                },
            ],

            language: {
                processing: `
                <div class="dt-loading-wrapper">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2">Loading data...</div>
                </div>
            `,
            },
        });
    }

    $("#table_sales_order").on("click", ".btn-detail-so", function () {
        const soId = $(this).data("id");
        const soNumber = $(this).data("so");

        $("#soNumberTitle").text(soNumber);
        $("#modalDetailSO").modal("show");

        if (tableDetailSO) {
            tableDetailSO.clear().destroy();
        }

        tableDetailSO = $("#table_so_detail").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            responsive: true,

            dom:
                "<'row mb-2'<'col-md-6'l><'col-md-6 text-right'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",

            ajax: {
                url:
                    base_url +
                    "api/sales_order/droplist-sales-order-list-detail",
                type: "GET",
                data: function (d) {
                    d.sales_order_id = soId;
                },
            },

            columns: [
                { data: "sku_id" },
                { data: "sku_name" },
                { data: "sku_specification_code" },
                { data: null, defaultContent: "-" },
                { data: null, defaultContent: "-" },
                { data: "sku_inventory_unit" },
                { data: "term_of_payment" },
                { data: "quantity_order", className: "text-center" },
                { data: "outstanding", className: "text-center" },
                { data: "currency", className: "text-center" },
                { data: "exchange_rates", className: "text-center" },
                {
                    data: "price",
                    className: "text-right",
                    render: (d) => new Intl.NumberFormat("id-ID").format(d),
                },
                {
                    data: "total_price",
                    className: "text-right",
                    render: (d) => new Intl.NumberFormat("id-ID").format(d),
                },
                {
                    data: "outstanding",
                    className: "text-center",
                    render: (data) =>
                        data === 0
                            ? `<span class="badge badge-success">&nbsp;</span>`
                            : `<span class="badge badge-danger">&nbsp;</span>`,
                },
            ],

            language: {
                processing: `
                <div class="dt-loading-wrapper">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2">Loading data...</div>
                </div>
            `,
            },
        });
    });

    function reloadTableIfReady() {
        if (!tableProductPricelist) return;

        if (isFilterFilled()) {
            tableProductPricelist.ajax.reload();
        } else {
            tableProductPricelist.clear().draw();
        }
    }

    $("#customer, #valid_from, #valid_until, #type_item").on(
        "change",
        reloadTableIfReady,
    );

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        const target = $(e.target).attr("href");

        if (target === "#tab-request-content") {
            initTableProductPricelist();
            tableProductPricelist.columns.adjust();
        }

        if (target === "#tab-second-content") {
            initTableSalesOrderlist();
            tableSalesOrderlist.columns.adjust();
        }
    });

    initTableProductPricelist();

    $("#btn_filter_so").on("click", function () {
        tableSalesOrderlist.ajax.reload();
    });

    let selectedItems = [];

    const tableSelected = $("#table_product_pricelist_selected").DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        columns: [
            { data: "sku_id" },
            { data: "sku_name" },
            { data: "sku_specification_code" },
            { data: null, defaultContent: "-" },
            { data: null, defaultContent: "-" },
            { data: "sku_inventory_unit", className: "text-center" },

            { data: "qty", className: "text-center" },

            { data: "outstanding", className: "text-center" },

            { data: "top", className: "text-center" },

            { data: "currency", className: "text-center" },

            {
                data: "price",
                className: "text-right",
                render: (d) => new Intl.NumberFormat("id-ID").format(d),
            },

            {
                data: "amount",
                className: "text-right",
                render: (d) => new Intl.NumberFormat("id-ID").format(d),
            },

            {
                data: null,
                className: "text-center",
                render: () =>
                    `<button class="btn btn-sm btn-warning edit-item">✏️</button>
                 <button class="btn btn-sm btn-danger delete-item">🗑</button>`,
            },
        ],
    });

    function isCurrencyReady() {
        const currencyVal = $("#currency").val();
        const rateVal = parseFloat($("#exchange_rate").val());

        if (!currencyVal) {
            Swal.fire(
                "Error",
                "Currency harus dipilih terlebih dahulu",
                "error",
            );
            return false;
        }

        if (!rateVal || rateVal <= 0) {
            Swal.fire("Error", "Exchange Rate harus diisi", "error");
            return false;
        }

        return true;
    }

    $("#table_product_pricelist tbody").on("click", "tr", function () {
        if (!isCurrencyReady()) return;

        const data = tableProductPricelist.row(this).data();
        if (!data) return;

        const exists = selectedItems.find((i) => i.sku_id === data.sku_id);
        if (exists) {
            Swal.fire("Info", "Item sudah di add", "warning");
            return;
        }

        $("#modal_sku_id").val(data.sku_id);
        $("#modal_qty").val(1);
        $("#modal_top").val(100);

        $("#modalItemInput").modal("show");

        $("#btnSaveItem")
            .off()
            .on("click", function () {
                const qty = parseInt($("#modal_qty").val());
                const top = parseInt($("#modal_top").val());

                if (!qty || qty < 1) {
                    Swal.fire("Error", "Quantity harus diisi", "error");
                    return;
                }

                if (top < 1 || top > 100) {
                    Swal.fire("Error", "TOP harus 1 - 100", "error");
                    return;
                }

                const exchangeRate = parseFloat($("#exchange_rate").val());
                const currencyVal = $("#currency").val();

                const amount = qty * data.price * exchangeRate;

                const newItem = {
                    ...data,
                    qty,
                    outstanding: qty,
                    top,
                    currency: currencyVal,
                    exchange_rate: exchangeRate,
                    amount,
                };

                selectedItems.push(newItem);
                tableSelected.row.add(newItem).draw();

                $("#modalItemInput").modal("hide");
            });
    });

    $("#table_product_pricelist_selected tbody").on(
        "click",
        ".edit-item",
        function () {
            if (!isCurrencyReady()) return;

            const row = tableSelected.row($(this).parents("tr"));
            const data = row.data();

            $("#modal_qty").val(data.qty);
            $("#modal_top").val(data.top);

            $("#modalItemInput").modal("show");

            $("#btnSaveItem")
                .off()
                .on("click", function () {
                    const qty = parseInt($("#modal_qty").val());
                    const top = parseInt($("#modal_top").val());

                    if (!qty || qty < 1) {
                        Swal.fire("Error", "Quantity harus diisi", "error");
                        return;
                    }

                    if (top < 1 || top > 100) {
                        Swal.fire("Error", "TOP harus 1 - 100", "error");
                        return;
                    }

                    data.qty = qty;
                    data.outstanding = qty;
                    data.top = top;
                    const exchangeRate = parseFloat($("#exchange_rate").val());
                    data.exchange_rate = exchangeRate;
                    data.currency = $("#currency").val();
                    data.amount = qty * data.price * exchangeRate;

                    row.data(data).draw();
                    $("#modalItemInput").modal("hide");
                });
        },
    );

    $("#table_product_pricelist_selected tbody").on(
        "click",
        ".delete-item",
        function () {
            const row = tableSelected.row($(this).parents("tr"));
            const data = row.data();

            Swal.fire({
                title: "Hapus item?",
                text: data.sku_name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
            }).then((res) => {
                if (res.isConfirmed) {
                    selectedItems = selectedItems.filter(
                        (i) => i.sku_id !== data.sku_id,
                    );
                    row.remove().draw();
                }
            });
        },
    );

    function resetSalesOrderForm() {
        selectedItems = [];
        tableSelected.clear().draw();

        $("#po_number").val("");
        $("#customer").val(null).trigger("change");
        $("#currency").val(null).trigger("change");
        $("#exchange_rate").val("1");
        $("#type_item").val(null).trigger("change");
        $("input[name='po_number']").val("");

        lastCustomer = null;
    }

    $("#btnSaveSO").on("click", function () {
        if (!isFilterFilled()) {
            Swal.fire("Error", "Lengkapi semua form di atas", "error");
            return;
        }

        if (!$("#currency").val() || !$("#exchange_rate").val()) {
            Swal.fire("Error", "Currency & Exchange Rate wajib diisi", "error");
            return;
        }

        if (selectedItems.length === 0) {
            Swal.fire("Error", "Minimal 1 item harus ditambahkan", "error");
            return;
        }

        if ($("input[name='po_number']").val().length === 0) {
            Swal.fire("Error", "PO Number wajib diisi", "error");
            return;
        }

        const payload = {
            po_number: $("input[name='po_number']").val(),
            customer_id: $("#customer").val(),
            valid_from: $("#valid_from").val(),
            valid_until: $("#valid_until").val(),
            currency: $("#currency").val(),
            exchange_rate: $("#exchange_rate").val(),
            items: selectedItems,
        };

        Swal.fire({
            title: "Simpan Sales Order?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, simpan",
        }).then((res) => {
            if (!res.isConfirmed) return;

            Swal.fire({
                title: "Menyimpan...",
                text: "Mohon tunggu",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                url: base_url + "api/sales_order/insert-sales-order",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                data: JSON.stringify(payload),
                contentType: "application/json",
                success: function (res) {
                    Swal.close();

                    if (res.status) {
                        Swal.fire("Success", res.message, "success");
                        resetSalesOrderForm();
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                },
                error: function (xhr) {
                    Swal.close();

                    Swal.fire(
                        "Error",
                        xhr.responseJSON?.message || "Server error",
                        "error",
                    );
                },
            });
        });
    });

    function recalculateSelectedItems() {
        const exchangeRate = parseFloat($("#exchange_rate").val());
        const currencyVal = $("#currency").val();

        if (!exchangeRate || exchangeRate <= 0) return;

        selectedItems = selectedItems.map((item) => {
            item.currency = currencyVal;
            item.exchange_rate = exchangeRate;
            item.amount = item.qty * item.price * exchangeRate;
            return item;
        });

        tableSelected.clear().rows.add(selectedItems).draw();
    }

    $("#currency, #exchange_rate").on("change input", function () {
        if (selectedItems.length > 0) {
            recalculateSelectedItems();
        }
    });
});
