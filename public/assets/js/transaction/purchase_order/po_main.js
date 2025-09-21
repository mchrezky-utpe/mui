import { initParam } from "./po_param.js";
import { handleTableServerSide } from "./po_table_server_side.js";
import { handleActionTable } from "./po_action_table.js";

$(document).ready(function () {
    initParam();
    handleTableServerSide();
    handleActionTable();


    $(document).on("click", ".btn_detail", function (e) {
        e.preventDefault();

        var table = $("#table-po").DataTable();
        var row = table.row($(this).closest("tr"));
        var data = row.data();

        var po_id = $(this).data("id"); // ID dari button data-id

        console.log("Button clicked, PO ID:", po_id);
        console.log("Row data:", data);

        // Validasi PO ID
        if (!po_id) {
            console.error("PO ID tidak ditemukan");
            alert("Error: PO ID tidak ditemukan");
            return;
        }

        $("#detail_id").text(data.id || "-");
        $("#detail_doc_num").text(data.doc_num || "-");
        $("#detail_supplier").text(data.supplier || "-");
        $("#detail_date").text(data.trans_date || "-");
        $("#detail_po_type").text(data.po_type || "-");
        $("#detail_description").text(data.description || "-");
        $("#detail_pr_doc_num").text(data.pr_doc_num || "-");
        $("#detail_edi_status").text(data.status_sent_to_edi || "-");
        $("#detail_po_status").text(data.po_status);
        $("#detail_file").text(data.file || "-");
        $("#detail_revision").text(data.rev_counter || "-");
        $("#detail_terms").text(data.terms || "-");
        $("#detail_department").text(data.department || "-");

        $("#detail_currency").text(data.currency || "-");
        $("#detail_sub_total").text(data.val_sub_total || "-");
        $("#detail_ppn").text(data.val_vat || "-");
        $("#detail_pph23").text(data.val_pph23 || "-");
        $("#detail_discount").text(data.val_discount || "-");
        $("#detail_total").text(data.val_total || "-");

        loadPoDetailItems(po_id);

        $("#detail_modal").modal("show");
    });

    // Function to load PO detail items
    function loadPoDetailItems(po_id) {
        console.log("Loading PO items for ID:", po_id);

        // Clear existing table data
        $("#detail_table tbody").empty();

        // Show loading state
        $("#detail_table tbody").html(`
            <tr>
                <td colspan="10" class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    Loading items...
                </td>
            </tr>
        `);

        // Construct URL
        var ajaxUrl = window.location.origin + `/po/${po_id}/items`;
        console.log("AJAX URL:", ajaxUrl);

        // AJAX call to get PO detail items
        $.ajax({
            url: ajaxUrl,
            type: "GET",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Accept: "application/json",
            },
            timeout: 15000, // 15 detik timeout
            success: function (response) {
                console.log("AJAX Success Response:", response);
                $("#detail_table tbody").empty();

                // Handle different response formats
                var items = null;

                if (response && response.success && response.data) {
                    items = response.data;
                } else if (response && response.data) {
                    items = response.data;
                } else if (Array.isArray(response)) {
                    items = response;
                }

                if (items && items.length > 0) {
                    $.each(items, function (index, item) {
                        console.log(`Processing item ${index + 1}:`, item);

                        // Safe property access dengan fallback - disesuaikan dengan struktur tabel baru

                        var row = `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${item.sku_prefix}</td>
                                <td>${item.sku_description}</td>
                                <td>${item.sku_specification_code}</td>
                                <td>${item.sku_type}</td>
                                <td>${item.sku_inventory_unit}</td>
                                <td class="text-right">${formatCurrency(
                                    item.price_f
                                )}</td>
                                <td class="text-center">${formatNumber(
                                    item.qty
                                )}</td>
                                <td class="text-right">${formatCurrency(
                                    item.total_f
                                )}</td>
                                <td class="text-right">-</td>
                                <td class="text-right">-</td>
                                <td class="text-right">-</td>
                                <td class="text-right">-</td>
                            </tr>
                        `;
                        $("#detail_table tbody").append(row);
                    });

                    // Tambahkan baris total di akhir tabel
                    // calculateAndDisplayTotals(items);
                } else {
                    var message = "No items found for this PO";
                    if (response && response.message) {
                        message = response.message;
                    }

                    $("#detail_table tbody").html(`
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i>
                                ${message}
                            </td>
                        </tr>
                    `);
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = "Error loading items. Please try again.";
                var debugInfo = "";

                // Parse error response untuk info lebih detail
                try {
                    var errorResponse = JSON.parse(xhr.responseText);
                    if (errorResponse.message) {
                        errorMessage = errorResponse.message;
                    }
                    if (errorResponse.debug_info) {
                        debugInfo = JSON.stringify(errorResponse.debug_info);
                    }
                } catch (e) {
                    // Tidak bisa parse JSON, gunakan response text
                    if (xhr.responseText) {
                        debugInfo = xhr.responseText.substring(0, 200) + "...";
                    }
                }

                // More specific error messages
                if (xhr.status === 404) {
                    errorMessage =
                        "Endpoint not found. Please check your routes.";
                } else if (xhr.status === 500) {
                    errorMessage =
                        "Server error occurred. Check logs for details.";
                } else if (xhr.status === 403) {
                    errorMessage = "Access denied. Please check permissions.";
                } else if (xhr.status === 0) {
                    errorMessage =
                        "Network error. Please check your connection.";
                } else if (status === "timeout") {
                    errorMessage = "Request timeout. Please try again.";
                }

                $("#detail_table tbody").html(`
                    <tr>
                        <td colspan="10" class="text-center text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            ${errorMessage}
                            <br><small>Status: ${xhr.status} - ${error}</small>
                            ${
                                debugInfo
                                    ? `<br><small class="text-muted">Debug: ${debugInfo}</small>`
                                    : ""
                            }
                            <br><button onclick="loadPoDetailItems(${po_id})" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-redo"></i> Retry
                            </button>
                        </td>
                    </tr>
                `);
            },
        });
    }

    // Function untuk menghitung dan menampilkan total
    function calculateAndDisplayTotals(items) {
        let totalSubTotal = 0;
        let totalDiscount = 0;
        let totalAfterDiscount = 0;
        let totalVat = 0;
        let grandTotal = 0;

        items.forEach(function (item) {
            var price = safeGet(item, ["price", "unit_price", "cost"], 0);
            var qty = safeGet(item, ["qty", "qty_ordered", "quantity"], 0);
            var subTotal = safeGet(
                item,
                ["sub_total", "subtotal"],
                price * qty
            );
            var discount = safeGet(item, ["discount", "discount_amount"], 0);
            var afterDiscount = safeGet(
                item,
                ["after_discount", "net_amount"],
                subTotal - discount
            );
            var vat = safeGet(item, ["vat", "tax", "tax_amount"], 0);
            var total = safeGet(
                item,
                ["total", "total_amount", "final_amount"],
                afterDiscount + vat
            );

            totalSubTotal += parseFloat(subTotal) || 0;
            totalDiscount += parseFloat(discount) || 0;
            totalAfterDiscount += parseFloat(afterDiscount) || 0;
            totalVat += parseFloat(vat) || 0;
            grandTotal += parseFloat(total) || 0;
        });

        // Tambahkan baris total
        var totalRow = `
            <tr class="table-active font-weight-bold">
                <td class="text-center">-</td>
                <td colspan="2" class="text-right"><strong>TOTAL:</strong></td>
                <td class="text-right">-</td>
                <td class="text-center">-</td>
                <td class="text-right"><strong>${formatCurrency(
                    totalSubTotal
                )}</strong></td>
                <td class="text-right"><strong>${formatCurrency(
                    totalDiscount
                )}</strong></td>
                <td class="text-right"><strong>${formatCurrency(
                    totalAfterDiscount
                )}</strong></td>
                <td class="text-right"><strong>${formatCurrency(
                    totalVat
                )}</strong></td>
                <td class="text-right"><strong>${formatCurrency(
                    grandTotal
                )}</strong></td>
            </tr>
        `;
        $("#detail_table tbody").append(totalRow);
    }

    // Helper function untuk akses property yang aman
    function safeGet(obj, keys, defaultValue = null) {
        if (!obj) return defaultValue;

        for (let key of keys) {
            if (
                obj.hasOwnProperty(key) &&
                obj[key] !== null &&
                obj[key] !== undefined
            ) {
                return obj[key];
            }
        }
        return defaultValue;
    }

    // Helper function to format numbers
    function formatNumber(value) {
        if (
            value === null ||
            value === undefined ||
            value === "" ||
            isNaN(value)
        )
            return "0";
        return parseFloat(value).toLocaleString("id-ID");
    }

    // Helper function to format currency
    function formatCurrency(value) {
        if (
            value === null ||
            value === undefined ||
            value === "" ||
            isNaN(value)
        )
            return "Rp 0";
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(value);
    }

    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString || dateString === "-" || dateString === null)
            return "-";

        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;

            return date.toLocaleDateString("id-ID", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });
        } catch (e) {
            return dateString;
        }
    }

    // Expose function globally untuk bisa dipanggil dari button retry
    window.loadPoDetailItems = loadPoDetailItems;
});
