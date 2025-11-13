const table_goods = $("#table-rr-detail").DataTable({
        scrollX: true,
        scrollY: "400px",
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url + "goods-received/all",
            type: "GET",
            data: function (d) {
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
            },
        },
        columns: [
            {
                data: "rr_trans_date",
            },
            {
                data: "sku_prefix",
            },
            {
                data: "sku_name",
            },
            {
                data: "sku_material_type",
            },
            {
                data: "sku_classification",
            },
            {
                data: "sku_sales_category",
            },
            {
                data: "department",
            },
            {
                data: "doc_pr_num",
            },
            {
                data: "doc_num",
            },
            {
                data: "doc_sds_num",
            },
            {
                data: "doc_do_num",
            },
            {
                data: "supplier",
            },
            {
                data: "sku_inventory_unit",
            },
            {
                data: "qty_rr",
            },
            {
                data: "price_f",
            },
            {
                data: "subtotal_f",
            },
            {
                data: null,
            },
            {
                data: null,
            },
            {
                data: "doc_pi_num",
            }
        ],
        columnDefs: [ 
            {
                targets: 16,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    if(data.flag_alert_status == 1){
                        return  `<span style="background-color:green">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>`;
                    }
                    
                    return  `<span style="background-color:red">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>`;
                },
            },
            {
                targets: 17,
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    if(data.flag_alert_check == 1){
                        return  `<span style="background-color:green">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>`;
                    }
                    
                    return  `<span style="background-color:red">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>`;
                },
            },
        ]
    });

        $('#btn-filter').click(function() {
            table_goods.ajax.reload(); 
        });
    