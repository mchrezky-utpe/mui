export function handleActionTable() {

	$(document).on('change', '#supplier_select, #po_select', function() {
		const po_id = $('#po_select').val();
		$.ajax({
			type: 'GET',
			url: base_url + 'api/sdo/item',
			data:{id : po_id},
			success: function(response) {
				$("#item_table tbody tr").remove();
				$("#target_table tbody tr").remove();

				response.data.forEach(data => {
					const newRow = `
					<tr id="${data.id}">
						<td>${data.sku_prefix}<input type="hidden" name="detail_id[]" value="${data.id}" /><input name="qty[]" type="hidden" value="${data.qty}" /></td>
						<td>${data.sku_description}</td>
						<td>${data.sku_specification_code}</td>
						<td>${data.sku_type}</td>
						<td>${data.qty}</td>
						<td>${data.qty_outstanding}</td>
					</tr>
				`;
				$("#item_table tbody").append(newRow);
				});	

			},
			error: function(err) {
				console.error("Error fetching supplier master:", err);
			}
		});

	})

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