import { initParam } from "./sds_param.js";
import { handleTableServerSide } from "./sds_table_server_side.js";
import { handleActionTable } from "./sds_action_table.js";

$(document).ready(function () {
    initParam();
    // handleTableServerSide();
    handleActionTable();

    $(document).on("click", ".btn_detail", function (e) {
        var table = $("#table_sds").DataTable();
        var row = table.row($(this).closest("tr"));
        var data = row.data();

        var $row = $(this).closest("tr");
        var sds_id = $(this).data("id"); // ID dari button data-id

        // Mapping sesuai dengan struktur tabel HTML yang benar
        var rowData = {
            id: $row.data("id"), // menggunakan data-id dari <tr>
            sds_date: $row.find("td:nth-child(2)").text().trim(), // SDS Date
            doc_num: $row.find("td:nth-child(3)").text().trim(), // SDS Number
            department: $row.find("td:nth-child(4)").text().trim(), // Department
            supplier: $row.find("td:nth-child(5)").text().trim(), // Supplier
            sds_status: $row.find("td:nth-child(6)").text().trim(), // SDS
            rev_counter: $row.find("td:nth-child(7)").text().trim(), // Rev
            status_sent_to_edi: $row.find("td:nth-child(8)").text().trim(), // EDI
            sds_delivery: $row.find("td:nth-child(9)").text().trim(), // Delivery
            sds_shipment: $row.find("td:nth-child(10)").text().trim(), // Shipment
            status_reschedule: $row.find("td:nth-child(11)").text().trim(), // Reschedule
            date_reschedule: $row.find("td:nth-child(12)").text().trim(), // Date Reschedule
            rev_date: $row.find("td:nth-child(13)").text().trim(), // Date Revision
        };

        console.log(rowData);

        // Tampilkan data header di modal
        $("#detail_id").text(rowData.id);
        $("#detail_doc_num").text(rowData.doc_num);
        $("#detail_supplier").text(rowData.supplier);
        $("#detail_department").text(rowData.department);
        $("#detail_date").text(rowData.sds_date);
        $("#detail_status").text(rowData.sds_status);
        $("#detail_rev_counter").text(rowData.rev_counter);
        $("#detail_edi_status").text(rowData.status_sent_to_edi);
        $("#detail_delivery").text(rowData.sds_delivery);
        $("#detail_shipment").text(rowData.sds_shipment);
        $("#detail_reschedule").text(rowData.status_reschedule);
        $("#detail_date_reschedule").text(rowData.date_reschedule);
        $("#detail_rev_date").text(rowData.rev_date);

        // Load detail items via AJAX
        loadSdsDetailItems(sds_id);

        // Show modal
        $("#detail_modal").modal("show");
    });

    // Function to load SDS detail items
    function loadSdsDetailItems(sds_id) {
        // Clear existing table data
        $("#detail_table tbody").empty();

        // Show loading state
        $("#detail_table tbody").html(`
            <tr>
                <td colspan="9" class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    Loading items...
                </td>
            </tr>
        `);
    }

    // Helper function for status badge classes
    function getStatusBadgeClass(status) {
        switch (status?.toLowerCase()) {
            case "delivered":
            case "completed":
                return "success";
            case "pending":
            case "scheduled":
                return "warning";
            case "cancelled":
            case "rejected":
                return "danger";
            case "in_progress":
            case "processing":
                return "info";
            default:
                return "secondary";
        }
    }
});
