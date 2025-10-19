const table_pi_detail = $("#table-pi-detail").DataTable({
        scrollX: true,
        scrollY: "400px",
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "pi-detail/all",
            type: "GET",
            data: function (d) {
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
            },
        },
        columns: [
            {
                data: null,
            },
            {
                data: "doc_num",
            },
            {
                data: "manual_id",
            },
            {
                data: "trans_date",
            },
            {
                data: "department",
            },
            {
                data: "supplier",
            },
            {
                data: "pr_doc_num",
            },
            {
                data: "po_doc_num",
            },
            {
                data: "do_doc_num",
            },
            {
                data: "sku_prefix",
            },
            {
                data: "sku_name",
            },
            {
                data: "sku_specification_code",
            },
            {
                data: "sku_material_type",
            },
            {
                data: "price_f",
            },
            {
                data: "qty",
            },
            {
                data: "total_f",
            },
            {
                data: "flag_check",
            },
            {
                data: "flag_approval",
            }
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
        ],
    });

        $('#btn-filter').click(function() {
            table_pi_detail.ajax.reload(); 
        });
    