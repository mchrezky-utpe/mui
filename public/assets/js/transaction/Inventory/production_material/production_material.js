let tableProductionMaterial = null;
let tableStockIssue = null;

function initTableProductionMaterial() {
    if (tableProductionMaterial) return;

    tableProductionMaterial = $("#table_production_material").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,

        dom:
            "<'row mb-2'<'col-md-6'l><'col-md-6 text-right'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",

        ajax: {
            url: base_url + "api/production_material/droplist",
            type: "GET",
            data: function (d) {
                d.start_date = $("[name=start_date]").val();
                d.end_date = $("[name=end_date]").val();
                d.process_type = $("[name=process_type]").val();
            },
        },

        columns: [
            { data: "ps_code" },
            { data: "sku_sales_category" },
            { data: "request_date" },
            { data: "pmr_code" },
            { data: "sku_id" },
            { data: "sku_name" },
            { data: "sku_material_type" },
            { data: "sku_inventory_unit" },
            { data: "quantity_request", className: "text-right" },
            { data: "val_conversion", className: "text-right" },
            {
                data: "stock_status",
                className: "text-center",
                render: (data) =>
                    data === "AVAILABLE"
                        ? `<span class="badge badge-success">AVAILABLE</span>`
                        : `<span class="badge badge-danger">NOT AVAILABLE</span>`,
            },
            {
                data: "production_material_request_status",
                className: "text-center",
                render: (data) => {
                    const map = {
                        REQUESTED: "primary",
                        APPROVED: "success",
                        REJECTED: "danger",
                    };
                    return `<span class="badge badge-${map[data] ?? "secondary"}">${data}</span>`;
                },
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

function initTableStockIssue() {
    if (tableStockIssue) return;

    tableStockIssue = $("#table_stock_issue").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        responsive: true,

        dom:
            "<'row mb-2'<'col-md-6'l><'col-md-6 text-right'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",

        ajax: {
            url: base_url + "api/production_material/droplist-stock-issue",
            type: "GET",
            data: function (d) {
                d.stock_issue_date = $("[name=stock_issue_date]").val();
                d.stock_issue_type = $("[name=stock_issue_type]").val();
            },
        },

        columns: [
            { data: "sku_id" },
            { data: "sku_name" },
            { data: "sku_specification_code" },
            { data: "sku_material_type" },
            { data: "sku_inventory_unit" },
            { data: "val_conversion", className: "text-right" },
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

$('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    const target = $(e.target).attr("href");

    if (target === "#tab-request-content") {
        initTableProductionMaterial();
        tableProductionMaterial.columns.adjust();
    }

    if (target === "#tab-second-content") {
        initTableStockIssue();
        tableStockIssue.columns.adjust();
    }
});

$(document).ready(function () {
    initTableProductionMaterial();
});

$("#btn_filter_pmr").on("click", function () {
    tableProductionMaterial.ajax.reload();
});

$("#btn_filter_stock").on("click", function () {
    tableStockIssue.ajax.reload();
});

function getCurrentFilter() {
    const table = $("#table_production_material").DataTable();

    return {
        start_date: $("[name=start_date]").val(),
        end_date: $("[name=end_date]").val(),
        process_type: $("[name=process_type]").val(),
        search: table.search(),
    };
}

$("#btnApprove").on("click", async function () {
    const confirm = await Swal.fire({
        title: "Approve Data?",
        text: "All filtered production material requests will be APPROVED.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Approve",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#6c757d",
    });

    if (!confirm.isConfirmed) return;

    Swal.fire({
        title: "Processing...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    $.ajax({
        url: base_url + "api/production_material/approve",
        type: "POST",
        data: {
            ...getCurrentFilter(),
            action: "APPROVED",
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: res.message,
            });

            $("#table_production_material").DataTable().ajax.reload();
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to approve data",
            });
        },
    });
});

$("#btnReject").on("click", async function () {
    const confirm = await Swal.fire({
        title: "Reject Data?",
        text: "All filtered production material requests will be REJECTED.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Reject",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
    });

    if (!confirm.isConfirmed) return;

    Swal.fire({
        title: "Processing...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    $.ajax({
        url: base_url + "api/production_material/approve",
        type: "POST",
        data: {
            ...getCurrentFilter(),
            action: "REJECTED",
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: res.message,
            });

            $("#table_production_material").DataTable().ajax.reload();
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to reject data",
            });
        },
    });
});

$("#table_stock_issue tbody").on("click", "tr", function () {
    const data = tableStockIssue.row(this).data();
    if (!data) return;

    $("#si_sku_id").val(data.sku_id);
    $("#si_item_name").val(data.sku_name);
    $("#si_stock").val(data.val_conversion);
    $("#si_stock_view").val(data.val_conversion);
    $("#si_qty").val("");
    $("#qtyError").addClass("d-none");

    $("#modalStockIssue").modal("show");
});

$("#si_qty").on("input", function () {
    const maxStock = parseFloat($("#si_stock").val());
    const qty = parseFloat($(this).val());

    if (qty > maxStock) {
        $("#qtyError").removeClass("d-none");
        $("#btnSubmitStockIssue").prop("disabled", true);
    } else {
        $("#qtyError").addClass("d-none");
        $("#btnSubmitStockIssue").prop("disabled", false);
    }
});

$("#btnSubmitStockIssue").on("click", async function () {
    const qty = parseFloat($("#si_qty").val());
    const stock = parseFloat($("#si_stock").val());

    if (!qty || qty <= 0) {
        Swal.fire("Warning", "Qty must be greater than 0", "warning");
        return;
    }

    if (qty > stock) {
        Swal.fire("Error", "Qty exceeds available stock", "error");
        return;
    }

    const confirm = await Swal.fire({
        title: "Confirm Stock Issue?",
        text: `Issue qty ${qty}?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Submit",
    });

    if (!confirm.isConfirmed) return;

    Swal.fire({
        title: "Processing...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    $.ajax({
        url: base_url + "api/production_material/approve-stock-issue",
        type: "POST",
        data: {
            sku_id: $("#si_sku_id").val(),
            qty: qty,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (res) {
            Swal.fire("Success", res.message, "success");
            $("#modalStockIssue").modal("hide");
            tableStockIssue.ajax.reload();
        },
        error: function (xhr) {
            Swal.fire(
                "Error",
                xhr.responseJSON?.message || "Failed process",
                "error",
            );
        },
    });
});
