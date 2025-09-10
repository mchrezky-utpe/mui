  const table_pr = $("#table-pr-detail").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "pr-detail/api/all",
            type: "GET",
            data: function (d) {
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
                d.customer = $("#customer").val();
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
                data: "trans_date",
            },
            {
                data: "req_date",
            },
            {
                data: "department",
            },
            {
                data: "transaction_type",
            },
            {
                data: "status_type_item",
            },
            {
                data: "sku_id",
            },
            {
                data: "sku_name",
            },
            {
                data: "spec_code",
            },
            {
                data: "item_type",
            },
            {
                data: "sku_unit",
            },
            {
                data: "val_price",
            },
            {
                data: "qty",
            },
            {
                data: "val_total",
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