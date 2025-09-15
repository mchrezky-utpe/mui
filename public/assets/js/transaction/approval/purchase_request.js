$(document).ready(function () {
    $("#select_all").click(function () {
        $('input[name="id"]').prop("checked", this.checked);
    });

    $(".btn_action_approval").click(function () {
        var actionType = $(this).data("type");
        var selectedIds = [];

        $('input[name="id"]:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert("Pilih data terlebih dahulu!");
            return;
        }

        $("#action_type").val(actionType);
        $("#selected_ids").val(selectedIds.join(","));

        if (actionType === "approve") {
            $("#action_message").text("Approve");
            $("#form_modal").prop("action", "approval-pr/approve");
        } else if (actionType === "deny") {
            $("#action_message").text("Deny");
            $("#form_modal").prop("action", "approval-pr/deny");
        } else if (actionType === "hold") {
            $("#action_message").text("Hold");
            $("#form_modal").prop("action", "approval-pr/hold");
        }

        $("#approval_modal").modal("show");
    });

    let detailRowCount = 0;
    $(document).on("click", ".btn_detail", function (e) {
        var table = $("#table-pr").DataTable();
        var row = table.row($(this).closest("tr"));
        var data = row.data();

        var $row = $(this).closest("tr");
        var rowData = {
            id: $row.find("td:nth-child(3)").text().trim(),
            doc_num: $row.find("td:nth-child(4)").text().trim(),
            supplier: $row.find("td:nth-child(5)").text().trim(),
            date: $row.find("td:nth-child(6)").text().trim(),
            description: $row.find("td:nth-child(7)").text().trim(),
            pr_purpose: $row.find("td:nth-child(8)").text().trim(),
            status: $row.find("td:nth-child(9)").text().trim(),
        };

        console.log(rowData);

        // Tampilkan data header di modal
        $("#detail_supplier").text(rowData.supplier);
        $("#detail_date").text(rowData.date);
        $("#detail_description").text(rowData.description);
        $("#detail_status").text(rowData.status);
        $("#detail_doc_num").text(rowData.doc_num);
        $("#detail_id").text(rowData.id);
        $("#detail_pr_purpose").text(rowData.pr_purpose);

        console.log(data);
        debugger;
        var id = this.dataset.id;
        $.ajax({
            type: "GET",
            url: base_url + "approval-pr/item/" + id,
            success: function (data) {
                var data = data.data;
                $("#detail_table tbody").empty();
                detailRowCount = 0;
                for (let index = 0; index < data.length; index++) {
                    detailRowCount++;
                    let button_action = "";
                    if (data[index].flag_status === 0) {
                        button_action += `<button data-id="${data[index].id}" type="button" class="btn btn-danger btn-sm btn_deny">Deny</button>
                                <button data-id="${data[index].id}" type="button" class="btn btn-warning btn-sm btn_hold">Hold</button>`;
                    }
                    const newRow = `
                        <tr>
                            <td>${detailRowCount}</td>
                            <td>${data[index].sku_name}</td>
                            <td>${data[index].val_price}</td>
                            <td>${data[index].qty}</td>
                            <td>${data[index].val_total}</td>
                            <td>${data[index].req_date}</td>
                            <td>${data[index].description}</td>
                            <td>${data[index].item_status}</td>
                            <td>
                            ${button_action}
                            </td>
                        </tr>
                    `;

                    $("#detail_table tbody").append(newRow);
                }

                $("#detail_modal").modal("show");
            },
            error: function (err) {
                debugger;
            },
        });
    });

    // Ketika tombol Deny diklik
    $(document).on("click", ".btn_deny", function () {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        var id = this.dataset.id;
        $.ajax({
            type: "POST",
            url: base_url + "approval-pr/item/deny",
            async: false,
            data: {
                _token: csrfToken,
                id: id,
            },
            success: function (data) {
                alert("Succes deny item");
            },
            error: function (err) {
                debugger;
            },
        });
        $(this).closest("tr").find("td").eq(8).text("Hold");
        $(this).closest("tr").find("td").eq(9).remove();
    });

    // Ketika tombol Deny diklik
    $(document).on("click", ".btn_hold", function () {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        var id = this.dataset.id;
        $.ajax({
            type: "POST",
            url: base_url + "approval-pr/item/hofld",
            async: false,
            data: {
                _token: csrfToken,
                id: id,
            },
            success: function (data) {
                alert("Succes hold item");
            },
            error: function (err) {
                debugger;
            },
        });
        $(this).closest("tr").find("td").eq(8).text("Hold");
        $(this).closest("tr").find("td").eq(9).remove();
    });
});
