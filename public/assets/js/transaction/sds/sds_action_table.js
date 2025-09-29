import {
	skuMaster
} from './sds_global_variable.js';
import {
	calculateTotal
} from './sds_calculate.js';

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
		  $('#'+id).find('td:eq(4)').text(qty);
		  $('#'+id).find('td:eq(5)').text(0);
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
						<td>${data.qty_po}</td>
						<td>${data.qty_outstanding_sds}</td>
						<td>${data.req_date}</td>
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

	// SDS MAIN TABLE

	$(document).on('click', '.btn_reschedule', function (e) {
		var id = this.dataset.id;
		$('[name=id]').val(id);
		const doc_number_old = $(this).closest('tr').find('td').eq(2).text();
		$('[name=doc_number_old]').val(doc_number_old);
		// $('[name=name]').val(data.name);
		// $('[name=password]').val(data.password);

		$('#reschedule_modal').modal('show');
	});


	  $(document).on("click", ".btn_detail", function (e) {
        var table = $("#table_sds").DataTable();
        var row = table.row($(this).closest("tr"));
        var data = row.data();
		
        var sds_id = $(this).data("id"); // ID dari button data-id
 		$.ajax({
            type: "GET",
            url: base_url + "sds/" + sds_id +"/detail",
            success: function (response) {
            var data = response.data.header;
            var details = response.data.details;
        
			$("#detail_po_number").text(response.data.details[0].po_doc_num);
			$("#detail_doc_num").text(data.doc_num);
			$("#detail_supplier").text(data.supplier);
			$("#detail_department").text(response.data.details[0].department);
			$("#detail_date").text(data.trans_date);
			$("#detail_status").text(data.sds_status);
			$("#detail_rev_counter").text(data.rev_counter);
			$("#detail_edi_status").text(data.status_sent_to_edi);
			$("#detail_delivery").text(data.sds_delivery);
			$("#detail_shipment").text(data.sds_shipment);
			$("#detail_reschedule").text(data.status_reschedule);
			$("#detail_date_reschedule").text(data.date_reschedule);
			$("#detail_rev_date").text(data.rev_date);
           
			$("#item_table tbody").empty();
            for (let index = 0; index < details.length; index++) {
                const item = details[index];
                const newRow =
                    `
                        <tr>
                            <td>
                              ${item.sku_description}
                            </td>
                            <td>${item.sku_prefix}</td>
                            <td>${item.sku_specification_code}</td>
                            <td>${item.sku_type}</td>
                            <td>${item.sku_inventory_unit}</td>
                            <td>${item.qty}</td>
                            <td>-</td>
                        </tr>
            `;

                $("#item_table tbody").append(newRow);
            }
			
       			 $("#detail_modal").modal("show");
            },
            error: function (err) {
                debugger;
            },
        });
        // Load detail items via AJAX
        // loadSdsDetailItems(sds_id);

        // Show modal
    });

    // Function to load SDS detail items
    function loadSdsDetailItems(sds_id) {
        // Clear existing table data
        $("#detail_table tbody").empty();

        // Show loading state
        $("#detail_table tbody").html(`
            <tr>
                <td colspan="9" class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    Loading items...
                </td>
            </tr>
        `);
    }


}