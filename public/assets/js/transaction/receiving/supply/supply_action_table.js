import {
	skuMaster
} from './supply_global_variable.js';

export function handleActionTable() {

	var selectedRow = null;

	$(document).on('click','#item_table tbody tr', function() {
	  $('#qty_input').val("")
	  selectedRow = $(this);
	  $('#qty_sds_modal').modal('show'); 
	  $('#add_modal').hide(); 
	});

	$('#btn_confirm').click(function() {
		if (selectedRow) {
		 const id = selectedRow.attr('id');
		 const qty = $('#qty_input').val()
		 const additional = `<input type="hidden" name="detail_id[]" value="${id}" /><input value="${qty}" name="qty[]" type="hidden" />`;
		  $('#target_table tbody').append(selectedRow.append(additional));
		  $('#qty_sds_modal').modal('hide'); 
		  $('#add_modal').show(); 

		  // update value qty sds
		  $('#'+id).find('td:eq(5)').text(qty);
		  selectedRow = null; // Reset selectedRow
		}
	  });


	$(document).on('change', '#supplier_select, #po_select', function() {
		const po_id = $('#po_select').val();
		$.ajax({
			type: 'GET',
			url: base_url + 'api/supply/item',
			data:{id : po_id},
			success: function(response) {
				$("#item_table tbody tr").remove();
				$("#target_table tbody tr").remove();

				response.data.forEach(data => {
					const newRow = `
					<tr id="${data.id}">
						<td>${data.sku_id}</td>
						<td>${data.sku_name}</td>
						<td>${data.sku_specification_code}</td>
						<td>${data.sku_type}</td>
						<td>${data.sku_inventory_unit}</td>
						<td></td>
					</tr>
				`;
				$("#item_table tbody").append(newRow);
				});	

			},
			error: function(err) {
				console.error("Error fetching supplier master:", err);
			}
		});

	});
	

	// DETAIL CLICK
	$(document).on('click', '.btn_detail', function() {
		const id = this.dataset.id;
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sdo/detail',
			data:{id : id},
			success: function(response) {
				$("#detail_table tbody tr").remove();

				response.data.forEach(data => {
					const newRow = `
					<tr id="${data.id}">
						<td>${data.do_doc_num}</td>
						<td>${data.do_date}</td>
						<td>${data.po_doc_num}</td>
						<td>${data.description}</td>
						<td>${data.qty}</td>
						<td>${data.sku_description}</td>
						<td>${data.sku_prefix}</td>
					</tr>
				`;
				$("#detail_table tbody").append(newRow);
				});	
				
				$('#detail_modal').modal('show');

			},
			error: function(err) {
				console.error("Error fetching supplier master:", err);
			}
		});

	});
}