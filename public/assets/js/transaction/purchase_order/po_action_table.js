import {
	skuMaster, table_po
} from './po_global_variable.js';
import {
	calculateTotal
} from './po_calculate.js';

export function handleActionTable() {


	$('#btn-filter').click(function() {
		table_po.ajax.reload(); 
	});
	

	// action upload
	$(document).on('click','.upload', function(){
		const id = this.dataset.id;
		$('#po_id').val(id);
		$('#upload_modal').modal('show');
	});

	$(document).ready(function() {
		$('#fileInput').on('change', function() {
			var file = this.files[0];
			if (file) {
				var reader = new FileReader();
				reader.onload = function(e) {
					if (file.type === 'application/pdf') {
						$('#preview').html('<embed src="' + e.target.result + '" type="application/pdf" width="100%" height="400px" />');
					} else if (file.type === 'text/html') {
						$('#preview').html('<iframe src="' + e.target.result + '" width="100%" height="600px"></iframe>');
					} else {
						$('#preview').html('Unsupported file type');
					}
				};
				reader.readAsDataURL(file);
			}
		});
	});



	let rowCount = 0;
	$("#add_row").on("click", function() {
		const row = rowCount + 1;
		let sku_item
		skuMaster.forEach(data => {
			sku_item += `<option sku_description="` + data.sku.description + `" sku_prefix="` + data.sku.prefix + `"  price="` + data.price + `" value="` + data.sku.id + `" >` + data.sku.prefix + " - " + data.sku.description + `</option>`
		});
		const newRow = `
            <tr>
                <td>${row}</td>
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

	// =========== HANDLING ROW ADD OTHER COST
	let otherCostRowCount = 0;
	$("#add_row_other_cost").on("click", function() {
		otherCostRowCount++;
		const newRow = `
            <tr>
                <td>${otherCostRowCount}</td>
                <td><input type="text" class="form-control" name="description[]" placeholder="Description"></td>
                <td>
                    <select name="other_cost_id[]" class=form-control">
                        <option value="">
                            -- Select Cost --
                        </option>
                    </select>
                </td>
                <td><input type="number" class="form-control" name="price[]" placeholder="Price" step="0.01"></td>
                <td><input type="number" class="form-control" name="qty[]" placeholder="Qty" step="0.01"></td>
                <td><input type="number" class="form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
            </tr>
        `;

		$("#other_cost_table tbody").append(newRow);
	});


	$('#item_table').on('change', '.item_sku', function() {
		const price = $(this).find('option:selected').attr('price');
		const sku_description = $(this).find('option:selected').attr('sku_description');
		const prefix = $(this).find('option:selected').attr('sku_prefix');
		$(this).closest('tr').find('.price').val(price);
		$(this).closest('tr').find('.sku_description').val(sku_description);
		$(this).closest('tr').find('.sku_prefix').val(prefix);
	});


	// Event delegation for deleting rows
	$("#other_cost_table").on("click", ".delete_row", function() {
		$(this).closest("tr").remove();
		othrtCostUpdateRowNumbers();
	});

	// Update row numbers after deletion
	function othrtCostUpdateRowNumbers() {
		otherCostRowCount = 0;
		$("#other_cost_table tbody tr").each(function() {
			otherCostRowCount++;
			$(this).find("td:first").text(otherCostRowCount);
		});
	}

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

	$(document).on("click", ".edit", function (e) {

        var id = this.dataset.id;
        $.ajax({
            type: "GET",
            url: base_url + "po/" + id,
            success: function (data) {
                var data = data.data;
                $("[name=id]").val(data.id);
                $("[name=doc_num]").val(data.doc_num);
                $("[name=gen_terms_detail_id]").val(data.gen_terms_detail_id);
                $("[name=attention]").val(data.attention);
                $("[name=description]").val(data.description);
                $("#edit_modal").modal("show");
            },
            error: function (err) {
                debugger;
            },
        });

    });
}