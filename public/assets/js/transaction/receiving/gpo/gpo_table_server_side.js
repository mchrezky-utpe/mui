import {
	setGlobalVariable
} from './gpo_global_variable.js';

export function handleTableServerSide() {
	const table_gpo = $('#table-gpo').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: base_url + 'api/gpo/all',
			type: "GET",
			data: function(d) {
				d.start_date = $('input[name="start_date"]').val();
				d.end_date = $('input[name="end_date"]').val();
			}
		},
		columns: [{
				data: null
			},
			{
				data: "do_date"
			},
			{
				data: "do_doc_num"
			},
			{
				data: "gpo_type"
			},
			{
				data: "po_doc_num"
			},
			{
				data: "sku_prefix"
			},
			{
				data: "sku_description"
			},
			{ 
				data: "sku_specification_code" 
			},
			{
				data: "sku_type"
			},
			{
				data: "sku_inventory_unit"
			},
			{
				data: "qty"
			},
			{
				data: "outstanding_qty"
			},
			{
				data: null
			}
		],
		columnDefs: [{
				targets: 0, 
				orderable: false, 
				searchable: false, 
				render: function(data, type, row, meta) {
					return meta.row + 1;
				}
			},
			{
				targets: 12,
				render: function(data, type, row, meta) {
					return `<button data-id="`+data.trans_rr_id+`" type="button" class="btn_detail btn btn-info">
                        <span class="fas fa-eye"></span>
                      </button>`
				}
			}
		]
	});
	setGlobalVariable('table_gpo', table_gpo);
}