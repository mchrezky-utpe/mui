import {
	setGlobalVariable
} from './pr_global_variable.js';

export function handleTableServerSide() {
	const table_po = $('#table-pr').DataTable({
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
		columns: [{
				data: null
			}, // Kolom nomor urut
			{
				data: "manual_id"
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
				data: "supplier_name"
			},
			{
				data: "description"
			},
			{ data: "flag_status" },
			{
				data: null
			},
		],
		columnDefs: [{
				targets: 0, // Kolom nomor urut
				orderable: false, // Nomor urut tidak perlu sorting
				searchable: false, // Nomor urut tidak perlu pencarian
				render: function(data, type, row, meta) {
					return meta.row + 1; // Menampilkan nomor urut
				}
			},
			{
				targets: 8, // Kolom nomor urut
				orderable: false, // Nomor urut tidak perlu sorting
				searchable: false, // Nomor urut tidak perlu pencarian
				render: function(data, type, row, meta) {
					const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
					return `
                        <form action="/po/` + data.id + `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')"> 
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button data-id="` + data.id + `" type="button" class="create_po btn btn-primary">
                            	<span>+ PO</span>
                            </button>
							<button data-id="` + data.id + `" type="button" class="edit btn btn-success">
                            	<span class="fas fa-pencil-alt"></span>
                            </button>
                            <button type="submit" class="btn btn-danger">
                            	<span class="fas fa-trash"></span>
                            </button>
                        </form>
                    `; // Menampilkan nomor urut
				}
			}
		]
	});
	setGlobalVariable('table_po', table_po);
}