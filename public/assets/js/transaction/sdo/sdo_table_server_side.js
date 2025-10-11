import {
	setGlobalVariable
} from './sdo_global_variable.js';

export function handleTableServerSide() {
	
	
    const table_sdo = $("#table_sdo").DataTable({
     
        // scrollCollapse: true,
        // scrollX: true,
        // scrollY: 300,
        // fixedColumns: {
        //     right: 1,
        //     heightMatch: 'auto'
        // },
        processing: true,
        serverSide: true,
        ajax: {
		url: base_url + "api/sdo/all",
            type: "GET",
            data: function (d) {
                d.start_date = $('input[name="start_date"]').val();
                d.end_date = $('input[name="end_date"]').val();
                d.flag_status = $("#status").val();
            },
        },
        columns: [
            {
                data: "do_doc_num",
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
                data: "po_doc_num",
            },
            {
                data: "sds_doc_num",
            },
            {
                data: "description",
            },
            {
                data: "sku_description",
            },
            {
                data: "sku_prefix",
            },
            {
                data: "sku_specification_code",
            },
            {
                data: "sku_type",
            },
            {
                data: "qty",
            },
            {
                data: "qty_outstanding",
            }
        ],
        columnDefs: [],
    });
	setGlobalVariable('table_sdo', table_sdo);
}