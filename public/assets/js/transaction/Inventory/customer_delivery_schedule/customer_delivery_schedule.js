document.addEventListener("DOMContentLoaded", function () {
    let selectedItems = [];
    const customer = $("#customer");
    const modal_destination = $("#modal_destination");
    const validFrom = document.getElementById("valid_from");
    const validUntil = document.getElementById("valid_until");

    let lastCustomer = null;
    let allowChange = true;

    $("#customer").on("select2:select", function () {
        lastCustomer = $(this).val();
        loadCustomerDestination(lastCustomer);
    });

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
                loadCustomerDestination(newCustomer);

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

    $.ajax({
        url: base_url + "api/sales_order/droplist-list-customer",
        type: "GET",
        dataType: "json",
        success: function (res) {
            if (res.status) {
                customer
                    .empty()
                    .append('<option value="">-- Select Customer --</option>');

                res.data.forEach((item) => {
                    customer.append(
                        `<option value="${item.id}">${item.name}</option>`,
                    );
                });

                customer.select2({
                    placeholder: "Select Customer",
                    width: "100%",
                });
            }
        },
    });

    function loadCustomerDestination(customerId, selected = null) {
        modal_destination
            .empty()
            .append(
                '<option value="">-- Select Customer Destination --</option>',
            );

        if (!customerId) return;

        $.ajax({
            url:
                base_url +
                "api/customer_delivery_schedule/droplist-list-customer-destination",
            type: "GET",
            data: {
                customer_id: customerId,
            },
            dataType: "json",
            success: function (res) {
                if (res.status) {
                    res.data.forEach((item) => {
                        modal_destination.append(
                            `<option value="${item.id}">
                            ${item.destination_code} - ${item.destination_name}
                        </option>`,
                        );
                    });

                    modal_destination.select2({
                        dropdownParent: $("#modalItemInput"),
                        placeholder: "Select Customer Destination",
                        width: "100%",
                    });

                    if (selected) {
                        modal_destination.val(selected).trigger("change");
                    }
                }
            },
        });
    }

    //load datatable
    let tableSalesOrderlist = null;

    function isFilterFilled() {
        return (
            $("#customer").val() &&
            $("#valid_from").val() &&
            $("#valid_until").val() &&
            $("#cust_delivery_num").val()
        );
    }

    function initTableSalesOrderlist() {
        if (tableSalesOrderlist) return;

        tableSalesOrderlist = $("#table_sales_order_list").DataTable({
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
                url:
                    base_url +
                    "api/customer_delivery_schedule/droplist-sales-order-list",
                type: "GET",

                data: function (d) {
                    d.customer = $("#customer").val();
                    d.valid_from = $("#valid_from").val();
                    d.valid_until = $("#valid_until").val();
                    d.po_number = $("#cust_delivery_num").val();
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
                { data: "so_number" },
                { data: "po_number" },
                { data: "sku_id" },
                { data: "sku_name" },
                { data: "sku_specification_code" },
                { data: null, defaultContent: "-" },
                { data: null, defaultContent: "-" },
                { data: "quantity_order", className: "text-center" },
                { data: "outstanding", className: "text-center" },
                { data: "valid_from" },
                { data: "valid_until" },
                { data: "validation_status" },
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

    function reloadTableIfReady() {
        if (!tableSalesOrderlist) return;

        if (isFilterFilled()) {
            tableSalesOrderlist.ajax.reload();
        } else {
            tableSalesOrderlist.clear().draw();
        }
    }

    $("#customer, #valid_from, #valid_until, #cust_delivery_num").on(
        "change",
        reloadTableIfReady,
    );

    $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        const target = $(e.target).attr("href");

        if (target === "#tab-request-content") {
            initTableSalesOrderlist();
            tableSalesOrderlist.columns.adjust();
        }
    });

    initTableSalesOrderlist();

    const tableSelected = $("#table_sales_order_list_selected").DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        columns: [
            { data: "delivery_plan_date" },
            { data: "destination_name" },
            { data: "sku_id" },
            { data: "sku_name" },
            { data: "sku_specification_code" },
            { data: null, defaultContent: "-" },
            { data: null, defaultContent: "-" },
            { data: "quantity_order", className: "text-center" },
            {
                data: null,
                className: "text-center",
                render: () =>
                    `<button class="btn btn-sm btn-warning edit-item">✏️</button>
                 <button class="btn btn-sm btn-danger delete-item">🗑</button>`,
            },
        ],
    });

    $("#table_sales_order_list tbody").on("click", "tr", function () {
        const data = tableSalesOrderlist.row(this).data();
        if (!data) return;

        const exists = selectedItems.find((i) => i.sku_id === data.sku_id);
        if (exists) {
            Swal.fire("Info", "Item sudah di add", "warning");
            return;
        }

        const maxQty = parseInt(data.outstanding);

        $("#modal_sku_id").val(data.sku_id);
        $("#modal_qty").val(1).attr("max", maxQty);
        $("#modal_qty_max_label").text(maxQty);
        $("#modal_max_qty").val(maxQty);
        $("#modal_delivery_date").val(new Date().toISOString().split("T")[0]);
        loadCustomerDestination($("#customer").val());

        $("#modalItemInput").modal("show");

        $("#btnSaveItem")
            .off()
            .on("click", function () {
                const qty = parseInt($("#modal_qty").val());
                const maxQty = parseInt($("#modal_max_qty").val());
                const deliveryDate = $("#modal_delivery_date").val();
                const destination = $("#modal_destination").val();
                const destinationName = $(
                    "#modal_destination option:selected",
                ).text();

                if (!deliveryDate) {
                    Swal.fire(
                        "Error",
                        "Delivery Plan Date wajib diisi",
                        "error",
                    );
                    return;
                }

                if (!destination) {
                    Swal.fire("Error", "Destination wajib diisi", "error");
                    return;
                }

                if (!qty || qty < 1 || qty > maxQty) {
                    Swal.fire("Error", `Quantity max ${maxQty}`, "error");
                    return;
                }

                const newItem = {
                    ...data,
                    delivery_plan_date: deliveryDate,
                    destination_code: destination,
                    destination_name: destinationName,
                    quantity_order: qty,
                };

                selectedItems.push(newItem);
                tableSelected.row.add(newItem).draw();
                $("#modalItemInput").modal("hide");
            });
    });

    $("#table_sales_order_list_selected tbody").on(
        "click",
        ".edit-item",
        function () {
            const row = tableSelected.row($(this).parents("tr"));
            const data = row.data();

            const maxQty = parseInt(data.outstanding);

            $("#modal_qty").val(data.quantity_order).attr("max", maxQty);
            $("#modal_qty_max_label").text(maxQty);
            $("#modal_max_qty").val(maxQty);
            $("#modal_delivery_date").val(data.delivery_plan_date);
            loadCustomerDestination(
                $("#customer").val(),
                data.destination_code,
            );

            $("#modalItemInput").modal("show");

            $("#btnSaveItem")
                .off()
                .on("click", function () {
                    const qty = parseInt($("#modal_qty").val());
                    const deliveryDate = $("#modal_delivery_date").val();
                    const destination = $("#modal_destination").val();

                    if (!deliveryDate || !destination) {
                        Swal.fire("Error", "Semua field wajib diisi", "error");
                        return;
                    }

                    if (!qty || qty < 1 || qty > maxQty) {
                        Swal.fire("Error", `Quantity max ${maxQty}`, "error");
                        return;
                    }

                    data.delivery_plan_date = deliveryDate;
                    data.destination_code = destination;
                    const destinationName = $(
                        "#modal_destination option:selected",
                    ).text();
                    data.destination_name = destinationName;
                    data.quantity_order = qty;

                    row.data(data).draw();
                    $("#modalItemInput").modal("hide");
                });
        },
    );

    $("#table_sales_order_list_selected tbody").on(
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

    $("#btnSaveCDS").on("click", function () {
        if (!isFilterFilled()) {
            Swal.fire("Error", "Lengkapi semua form di atas", "error");
            return;
        }

        if (selectedItems.length === 0) {
            Swal.fire("Error", "Minimal 1 item harus ditambahkan", "error");
            return;
        }

        const payload = {
            po_number: $("input[name='cust_delivery_num']").val(),
            customer_id: $("#customer").val(),
            valid_from: $("#valid_from").val(),
            valid_until: $("#valid_until").val(),
            items: selectedItems,
        };

        Swal.fire({
            title: "Simpan Customer Delivery Schedule?",
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
                url:
                    base_url +
                    "api/customer_delivery_schedule/insert-customer-delivery-schedule",
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
});
