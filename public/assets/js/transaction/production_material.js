let table = $("#table_production_material").DataTable({
    processing: true,
    serverSide: false,
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
    order: [[2, "desc"]],
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
            render: function (data) {
                return data === "AVAILABLE"
                    ? `<span class="badge badge-success">AVAILABLE</span>`
                    : `<span class="badge badge-danger">NOT AVAILABLE</span>`;
            },
        },
        {
            data: "production_material_request_status",
            className: "text-center",
            render: function (data) {
                const map = {
                    REQUESTED: "primary",
                    APPROVED: "success",
                    REJECTED: "danger",
                };

                return `<span class="badge badge-${map[data] ?? "secondary"}">${data}</span>`;
            },
        },
    ],
});

$(document).on("change", "[name=date]", function () {
    table.ajax.reload();
});

$("[name=date]").trigger("change");

$("#btn_filter").on("click", function () {
    table.ajax.reload();
});

function getCurrentFilter() {
    return {
        start_date: $("[name=start_date]").val(),
        end_date: $("[name=end_date]").val(),
        process_type: $("[name=process_type]").val(),
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
