import {
	setGlobalVariable
} from './gpo_global_variable.js';

export function handleTableServerSide() {
	const table_pr = $('#table-pr').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: base_url + 'pr/api/all',
			type: "GET",
			data: function(d) {
				d.start_date = $('input[name="start_date"]').val();
				d.end_date = $('input[name="end_date"]').val();
				d.customer = $('#customer').val();
			}
		},
		order: [
			[3, 'desc'],
			[2, 'desc']
		],
		columns: [{
				data: null
			},
			{
				data: "doc_num"
			},
			{
				data: "trans_date"
			},
			{
				data: "flag_type"
			},
			{
				data: null
			},
			{
				data: null
			},
			{
				data: "description"
			},
			{ 
				data: null 
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
			},{
				targets: 3,
				render: function(data, type, row, meta) {
					let flag_type = "";
					if(data.flag_type == 1){
						flag_type = "Production Project Material";
					}else {
						flag_type = "General Item";
					}
					return flag_type;
				}
			},{
				targets: 4,
				render: function(data, type, row, meta) {
					let purpose = "";
					if(data.flag_purpose == 1){
						purpose = "Project Development";
					}else if(data.flag_purpose == 2){
						purpose = "Additional";
					}else  if(data.flag_purpose == 3){
						purpose = "Recovery";
					}else {
						purpose = "Early Development";
					}
					return purpose;
				}
			},{
				targets: 7,
				render: function(data, type, row, meta) {
					let status = "";
					if(data.flag_status == 1){
						status = "Requested";
					}else if(data.flag_status == 2){
						status = "Approved";
					}else  if(data.flag_status == 3){
						status = "PO Active";
					}else {
						status = "Canceled";
					}
					return status;
				}
			},
			{
				targets: 8, 
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
					let button_action = ``;
					if(data.flag_status == 2){
						button_action = `
							<button data-id="` + data.id + `" type="button" class="create_po btn btn-primary">
                            	<span>+ PO</span>
                            </button>
							`;
					}else if(data.flag_status == 1){
						button_action = `
								<button data-id="` + data.id + `" type="button" class="edit btn btn-success">
									<span class="fas fa-pencil-alt"></span>
								</button>
								<button type="submit" class="btn btn-danger">
									<span class="fas fa-trash"></span>
								</button>`
					}
					return `
                        <form action="/pr/` + data.id + `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')"> 
                            <input type="hidden" name="_token" value="${csrfToken}">
							`+button_action+`
                        </form>
                    `; // Menampilkan nomor urut
				}
			},
			{
				targets: 5,
				render: function(data, type, row, meta) {
					return data.supplier_name + `<input type="hidden" name="supplier_id" value="${data.prs_supplier_id}">`;
				}
			}
		]
	});
	setGlobalVariable('table_pr', table_pr);
}