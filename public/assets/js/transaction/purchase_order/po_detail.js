const table_po = $("#table-po-detail").DataTable({
        scrollX: true,
        scrollY: "400px",
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "po-detail/api/all",
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
                data: "trans_date",
            },
            {
                data: "doc_num",
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
                data: "trans_pr_date",
            },
            {
                data: "doc_pr_num",
            },
            {
                data: "department",
            },
            {
                data: "transaction_type",
            },
            {
                data: "supplier",
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
                data: "description",
            },
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
            table_po.ajax.reload(); 
        });
    