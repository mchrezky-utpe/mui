import {
	setGlobalVariable
} from './po_global_variable.js';

export function handleTableServerSide() {
	const table_po = $('#table-po').DataTable({
		fixedColumns: {
			start: 0,
			end: 5
		},
		scrollCollapse: true,
		scrollX: true,
		scrollY: 300,

		processing: true,
		serverSide: true,
		ajax: {
			url: base_url + 'po/api/all',
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
			}, // Kolom nomor urut
			{
				data: "doc_num"
			},
			{
				data: "trans_date"
			},
			{
				data: "po_type"
			},
			{
				data: "supplier"
			},
			{
				data: "description"
			},
            {
				data: "pr_doc_num"
			},
			{
				data: null
			},
			{
				data: "file"
			},
			{
				data: "pr_doc_num"
			},
			{
				data: "pr_doc_num"
			},
			{
				data: null
			},
		],
		columnDefs: [
			{
				targets: 0,
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					return meta.row + 1;
				}
			},
			{
				targets: 7,
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					return 'Preparation';
				}
			},
			{
				targets: 11,
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
					return `
                        <form action="/po/` + data.id + `/delete" method="post" onsubmit="return confirm('Are you sure you want to delete it?')">
						<div class="d-flex">
							<input type="hidden" name="_token" value="${csrfToken}">
							<button data-id="${data.id}" type="button" target="_blank" class="upload btn btn-primary">
							 <span class="fas fa-upload"></span>
                            </button>
							<a  target="_blank"  href="po/` + data.id + `/print" class="print btn btn-secondary">
							 <span class="fas fa-print"></span>
                            </a>
							<button data-id="` + data.id + `" type="button" class="edit btn btn-success">
                            <span class="fas fa-pencil-alt"></span>
                            </button>
                            <button type="submit" class="btn btn-danger">
                            <span class="fas fa-trash"></span>
                            </button>
						</div>
						</form>
                    `;
				}
			}
		]
	});
	setGlobalVariable('table_po', table_po);
}
