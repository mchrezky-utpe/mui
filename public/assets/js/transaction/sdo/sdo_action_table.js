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
						<td>${data.item_code}<input type="hidden" name="detail_id[]" value="${data.id}" /><input name="qty[]" type="hidden" value="${data.qty}" /></td>
						<td>${data.item_name}</td>
						<td>${data.spec_code}</td>
						<td>${data.item_type}</td>
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

	});

	// SDO MAIN TABLE

	$(document).on('click', '.btn_reschedule', function (e) {
		var id = this.dataset.id;
		$('[name=id]').val(id);
		const doc_number_old = $(this).closest('tr').find('td').eq(2).text();
		$('[name=doc_number_old]').val(doc_number_old);
		// $('[name=name]').val(data.name);
		// $('[name=password]').val(data.password);

		$('#reschedule_modal').modal('show');
	});
}