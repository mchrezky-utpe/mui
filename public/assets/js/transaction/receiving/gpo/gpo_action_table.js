import {
	skuMaster
} from './gpo_global_variable.js';

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
		  const additional = `<input type="hidden" name="po_detail_id[]" value="${id}" /><input name="qty[]"  value="${qty}" type="hidden" />`;
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
			url: base_url + 'api/po/item',
			data:{id : po_id},
			success: function(response) {
				$("#item_table tbody tr").remove();
				$("#target_table tbody tr").remove();

				response.data.forEach(data => {
					const newRow = `
					<tr id="${data.po_detail_id}">
						<td>${data.item_code}</td>
						<td>${data.item_name}</td>
						<td>${data.specification_code}</td>
						<td>${data.item_type}</td>
						<td>${data.item_unit}</td>
						<td>${data.qty_po}</td>
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