$(document).ready(function () {

    // handling pagination data
    
	const table_pricelist = $('#table-pagination').DataTable({
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
			url: base_url + 'sku-pricelist/api/all/pagination',
			type: "GET",
			data: function(d) {
				d.start_date = $('input[name="start_date"]').val();
				d.flag_sku_type = 3;
				d.end_date = $('input[name="end_date"]').val();
				d.customer = $('#customer').val();
			}
		},
		columns: [{
				data: null
			}, 
			{
				data: "person_supplier"
			}, 
			{
				data: "sku_id"
			},
			{
				data: "sku_name"
			},
			{
				data: "sku_type"
			},
			{
				data: "sku_procurement_unit"
			},
			{
				data: "currency"
			}, 
            {
				data: "price"
			},
			{
				data: "price_retail"
			},
			{
				data: "pricelist_status"
			},
			{
				data: "valid_date_from"
			},
			{
				data: "valid_date_to"
			},
			{
				data: "valid_date_status"
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
				targets: 13,
				orderable: false,
				searchable: false,
				render: function(data, type, row, meta) {
					const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
					return `

                    <form action="/sku-pricelist/` + data.id + `/delete" method="post"> 
					<input type="hidden" name="_token" value="${csrfToken}">
                      <div class="d-flex">
                        <button data-prs_supplier_id="${data.prs_supplier_id}"  data-item_id="{{ $value->item_id }}"  type="button" class="history btn btn-secondary">
                          <span class="fas fa-list"></span>
                      </button>
                        <button data-id="${data.id}" type="button" class="edit btn btn-success">
                          <span class="fas fa-pencil-alt"></span>
                        </button>
                        <button class="btn btn-danger">
                          <span class="fas fa-trash"></span>
                        </button>
                      </form>
                    `;
				}
			}
		]
	});
    // end of hanlding pagination data
});
