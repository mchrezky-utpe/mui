import {
    skuMaster,
    table_pr
} from './pr_global_variable.js';
import {
    calculateTotal
} from './pr_calculate.js';

export function handleActionTable() {

    $(document).on('click', '.create_po', function () {
        var id = this.dataset.id;
        var supplier = $(this).closest('tr').find('td').eq(5).text();
        var pr_doc_numb = $(this).closest('tr').find('td').eq(1).text();
        var supplier_id = $(this).closest('tr').find('[name=supplier_id]').val();
        $('[name=id]').val(id);
        $('[name=pr_doc_numb]').val(pr_doc_numb);
        $('[name=supplier_name]').val(supplier);
        $('[name=prs_supplier_id]').val(supplier_id);
        $('#add_modal_po').modal('show');
    });

    let rowCount = 0;
    $("#add_row").on("click", function () {
        const row = rowCount + 1;
        let sku_item
        skuMaster.forEach(data => {
            sku_item += `<option sku_description="` + data.sku_name + `" sku_prefix="` + data.sku_id + `"  price="` + data.price + `" value="` + data.sku_pk_id + `" spec_code="` + data.sku_specification_code + `" >` + data.sku_id + " - " + data.sku_name + `</option>`
        });
        const newRow = `
            <tr>
                <td>${row}</td>
				<td>
					<select name="flag_type_detail[]" class="form-control item_sku">
                        <option value="">
                            -- Pick Purchase Item Type --
							<option value="1"> New Order </option>
							<option value="2"> Addition </option>
							<option value="3"> Replacement </option>
							<option value="4"> Services </option>
                        </option>
				</td>
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
                <!--<td><input type="number" class="price form-control" name="price[]" placeholder="Price" step="0.01"></td>-->
                <td style='display:none'><input type="hidden" class="sku_prefix form-control" name="sku_prefix[]"></td>
                <td style='display:none'><input type="hidden" class="sku_description form-control" name="sku_description[]"></td>
                <td><input type="number" class="qty form-control" name="qty[]" placeholder="Qty" step="1"></td>
                <td><input type="date" class="form-control" name="req_date[]" placeholder="Req Date" step="0.01"></td>
                <td><input type="text" class="form-control" name="description_item[]" placeholder="Description"></td>
                <td><input type="hidden" class="total form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
            </tr>
        `;

        $("#item_table tbody").append(newRow);
        rowCount++;
    });

    $('#item_table').on('change', '.item_sku', function () {
        const price = $(this).find('option:selected').attr('price');
        const sku_description = $(this).find('option:selected').attr('sku_description');
        const prefix = $(this).find('option:selected').attr('sku_prefix');
        const spec_code = $(this).find('option:selected').attr('spec_code');
        $(this).closest('tr').find('.price').val(price);
        $(this).closest('tr').find('.sku_description').val(sku_description);
        $(this).closest('tr').find('.specification_code').val(spec_code);
        $(this).closest('tr').find('.sku_prefix').val(prefix);
    });

    $('#item_table').on('input', '.price, .qty, .discount, .vat_percentage', function () {
        calculateTotal();
    });

    $('#tax_rate').on('input', function () {
        calculateTotal();
    });

    $("#item_table").on("click", ".delete_row", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });

    calculateTotal();
}
