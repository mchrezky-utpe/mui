import {
	skuMaster,
	table_pr
} from './pr_global_variable.js';
import {
	calculateTotal
} from './pr_calculate.js';

export function handleActionTable() {

	$(document).on('click','.create_po',function(){
		var id = this.dataset.id;
		var supplier = $(this).closest('tr').find('td').eq(6).text();
		var pr_doc_numb = $(this).closest('tr').find('td').eq(2).text();
		var supplier_id = $(this).closest('tr').find('[name=supplier_id]').val();
		$('[name=id]').val(id);
		$('[name=pr_doc_numb]').val(pr_doc_numb);
		$('[name=supplier_name]').val(supplier);
		$('[name=prs_suplier_id]').val(supplier_id);
		$('#add_modal_po').modal('show');
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

	$('#item_table').on('change', '.item_sku', function() {
		const price = $(this).find('option:selected').attr('price');
		const sku_description = $(this).find('option:selected').attr('sku_description');
		const prefix = $(this).find('option:selected').attr('sku_prefix');
		$(this).closest('tr').find('.price').val(price);
		$(this).closest('tr').find('.sku_description').val(sku_description);
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
}