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



	$(document).on('click','.create_po',function(){
		var id = this.dataset.id;
		var supplier = $(this).closest('tr').find('td').eq(6).text();
		var pr_doc_numb = $(this).closest('tr').find('td').eq(2).text();
		var supplier_id = $(this).closest('tr').find('[name=supplier_id]').val();
		$('[name=id]').val(id);
		$('[name=pr_doc_numb]').val(pr_doc_numb);
		$('[name=supplier_name]').val(supplier);
		$('[name=prs_supplier_id]').val(supplier_id);
		$('#add_modal_po').modal('show');
	});

	let rowCount = 0;
	$("#add_row").on("click", function() {
		const row = rowCount + 1;
		let sku_item
		skuMaster.forEach(data => {
			sku_item +=`"  req_date="` + data.req_date +  `<option sku_description="` + data.sku.description + `" sku_prefix="` + data.sku.prefix + `"  price="` + data.price + `" value="` + data.sku.id + `" spec_code="` + data.sku.specification_code + `" >` + data.sku.manual_id + " - " + data.sku.description + `</option>`
		});
		const newRow = `
            <tr>
                <td>${row}</td>
                <td><input type="date" class="form-control" name="req_date[]" placeholder="Req Date" step="0.01"></td>
                <td><input type="text" class="form-control" name="description_item[]" placeholder="Description"></td>
                <td>
                    <select name="sku_id[]" class="form-control item_sku">
                        <option value="">
                            -- Select SKU --
                        </option>
                        ` +
			sku_item +
			`
                    </select>
                </td>
                <td><input type="text" class="specification_code form-control" name="specification_code" readonly></td>
                <td><input type="text" class="form-control" name="item_type" readonly></td>
                <td><input type="text" class="form-control" name="purchase_item_type" readonly></td>
                <td><input type="number" class="price form-control" name="price[]" placeholder="Price" step="0.01"></td>
                <td style='display:none'><input type="hidden" class="sku_prefix form-control" name="sku_prefix[]" placeholder="Price" step="0.01"></td>
                <td style='display:none'><input type="hidden" class="sku_description form-control" name="sku_description[]" placeholder="Price" step="0.01"></td>
                <td><input type="number" class="qty form-control" name="qty[]" placeholder="Qty" step="1"></td>
                <td><input type="number" class="sub_total form-control" name="sub_total[]" placeholder="Sub Total" step="0.01" readonly></td>
                <td><input type="number" class="discount form-control" name="discount_percentage[]" placeholder="Discount %" step="0.01"></td>
                <td><input type="number" class="after_discount form-control" name="after_discount[]" placeholder="After Discount" step="0.01" readonly></td>
                <td><input type="number" class="vat_percentage form-control" name="vat_percentage[]" placeholder="VAT" step="0.01"></td>
                <td><input type="number" class="total form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
            </tr>
        `;

		$("#item_table tbody").append(newRow);
		rowCount++;
	});

	$('#item_table').on('change', '.item_sku', function() {
		const price = $(this).find('option:selected').attr('price');
		const sku_description = $(this).find('option:selected').attr('sku_description');
		const prefix = $(this).find('option:selected').attr('sku_prefix');
		const spec_code = $(this).find('option:selected').attr('spec_code');
		$(this).closest('tr').find('.price').val(price);
		$(this).closest('tr').find('.sku_description').val(sku_description);
		$(this).closest('tr').find('.specification_code').val(spec_code);
		$(this).closest('tr').find('.sku_prefix').val(prefix);
	});

	$('#item_table').on('input', '.price, .qty, .discount, .vat_percentage', function() {
		calculateTotal();
	});

	$('#tax_rate').on('input', function() {
		calculateTotal();
	});

	$("#item_table").on("click", ".delete_row", function() {
		$(this).closest("tr").remove();
		calculateTotal();
	});

	calculateTotal();

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
}