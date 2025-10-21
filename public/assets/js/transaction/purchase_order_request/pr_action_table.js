import { skuMaster, table_pr } from "./pr_global_variable.js";
import { calculateTotal } from "./pr_calculate.js";

export function handleActionTable() {


    $('#btn-filter').click(function() {
        table_pr.ajax.reload(); 
    });


    $(document).on("click", ".create_po", function () {
        
        $("#add_modal_po").modal("show");
        var id = this.dataset.id;
        var supplier = $(this).closest("tr").find("td").eq(6).text();
        var pr_doc_numb = $(this).closest("tr").find("td").eq(1).text();
        var supplier_id = $(this)
            .closest("tr")
            .find("[name=supplier_id]")
            .val();
        $("[name=id]").val(id);
        $("[name=pr_doc_numb]").val(pr_doc_numb);
        $("[name=supplier_name]").val(supplier);
        $("[name=prs_supplier_id]").val(supplier_id);
        
         $.ajax({
            type: "GET",
            url: base_url + "pr/" + id,
            success: function (data) {
            var data = data.data;
            const sub_total = data.items.reduce((accumulator, item) => accumulator + parseFloat(item.subtotal_f) , 0);
            const total  = data.items.reduce((accumulator, item) => accumulator + parseFloat(item.total_f) , 0);
            $("[name=sub_total]").val(sub_total.toFixed(0));
            $("[name=total]").val(total.toFixed(0));
            $(".item_table tbody").empty();
            let rowCount = 1;
            for (let index = 0; index < data.items.length; index++) {
                const item = data.items[index];
                const newRow =
                    `
                        <tr>
                            <td>${rowCount}</td>
                            <td> 
                            ${item.flag_type == 1 ? `New Order` : ``}
                            ${item.flag_type == 2 ? `Addition` : ``} 
                            ${item.flag_type == 3 ? `Replacement` : ``}
                            ${item.flag_type == 4 ? `Services` : ``} 
                            </td>
                            <td>
                                ${item.sku_prefix} - ${item.sku_description}
                            </td>
                            <td>${Number(item.price_f).toFixed()}</td>
                            <td style='display:none'></td>
                            <td style='display:none'></td>
                            <td>${Number(item.qty).toFixed()}</td>
                            <td>${item.req_date}</td>
                            <td>${item.description}</td>
                            <td></td>
                            <td></td>
                        </tr>
            `;

                $(".item_table tbody").append(newRow);
                rowCount++;
            }
            },
            error: function (err) {
                debugger;
            },
        });

        $("#add_modal_po").modal("show");
    });


    function calculateAll() {
        const subTotal = parseFloat($('#sub_total').val()) || 0;
        
        const ppnPercent = parseFloat($('#ppn').val()) || 0;
        const pph23Percent = parseFloat($('#pph23').val()) || 0;
        const discountPercent = parseFloat($('#discount').val()) || 0;
        
        const validPpnPercent = Math.min(ppnPercent, 100);
        const validPph23Percent = Math.min(pph23Percent, 100);
        const validDiscountPercent = Math.min(discountPercent, 100);
        
        if (ppnPercent !== validPpnPercent) $('#ppn').val(validPpnPercent);
        if (pph23Percent !== validPph23Percent) $('#pph23').val(validPph23Percent);
        if (discountPercent !== validDiscountPercent) $('#discount').val(validDiscountPercent);
        
        const discountAmount = (subTotal * validDiscountPercent) / 100;
        const totalAfterDiscount = subTotal - discountAmount;
        
        const ppnAmount = (totalAfterDiscount * validPpnPercent) / 100;
        const pph23Amount = (totalAfterDiscount * validPph23Percent) / 100;
        
        const grandTotal = totalAfterDiscount + ppnAmount - pph23Amount;
        
        $('#discount_total').val(discountAmount.toFixed(0));
        $('#ppn_total').val(ppnAmount.toFixed(0));
        $('#pph23_total').val(pph23Amount.toFixed(0));
        $('#total').val(grandTotal.toFixed(0));
    }

    // Event listeners untuk input persentase
    $('#ppn, #pph23, #discount').on('input', calculateAll);

    // Event listener untuk sub_total (jika bisa diubah)
    $('#sub_total').on('input', calculateAll);

    // Inisialisasi awal
    calculateAll();



    var rowCount = 1;
    $(".add_row").on("click", function () {
        const row = rowCount;
        const supplier = $('#supplier_select').val();
        let sku_item;
        skuMaster.forEach((data) => {
            sku_item +=
                `<option sku_description="` +
                data.sku_name +
                `" sku_prefix="` +
                data.sku_id +
                `"  price="` +
                data.price +
                `" value="` +
                data.sku_pk_id +
                `" spec_code="` +
                data.sku_specification_code +
                `"  moq="` +
                data.moq +
                `" >` +
                data.sku_id +
                " - " +
                data.sku_name +
                `</option>`;
        });
        const newRow =
            `
            <tr>
                <td>${row}</td>
				<td>
					<select required name="flag_type_detail[]" class="form-control item_sku">
                        <option value="">
                            -- Pick Purchase Item Type --
							<option value="1"> New Order </option>
							<option value="2"> Addition </option>
							<option value="3"> Replacement </option>
							<option value="4"> Services </option>
                        </option>
				</td>
                <td>
                    <select required name="sku_id[]" class="form-control item_sku product-select" data-row="${row}">
                        <option value="">
                            -- Select SKU --
                        </option>
                        ` +
            sku_item +
            `
                    </select>
                </td>
                <td><input type="number" class="price form-control" name="price[]" placeholder="Price"  required></td>
                <td style='display:none'><input type="hidden" class="sku_prefix form-control" name="sku_prefix[]" ></td>
                <td style='display:none'>
                    <input type="hidden" class="sku_description form-control" name="sku_description[]">
                    <input type="hidden" class="moq form-control" name="moq[]">
                </td>
                <td><input type="number" class="qty form-control" name="qty[]" placeholder="Qty" step="1"  required></td>
                <td><input type="date" class="form-control" name="req_date[]" placeholder="Req Date" required></td>
                <td><input type="text" class="form-control" name="description_item[]" placeholder="Description"  required></td>
                <td><input type="hidden" class="total form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
            </tr>
        `;

        $(".item_table tbody").append(newRow);
        rowCount++;
    });

    $(".item_table").on("change", ".item_sku", function () {
        validateItemSelect($(this));

        const price = Number($(this).find("option:selected").attr("price")).toFixed(0);
        const sku_description = $(this)
            .find("option:selected")
            .attr("sku_description");
        const prefix = $(this).find("option:selected").attr("sku_prefix");
        const spec_code = $(this).find("option:selected").attr("spec_code");
        const moq = $(this).find("option:selected").attr("moq");
        $(this).closest("tr").find(".price").val(price);
        $(this).closest("tr").find(".sku_description").val(sku_description);
        $(this).closest("tr").find(".specification_code").val(spec_code);
        $(this).closest("tr").find(".sku_prefix").val(prefix);
        $(this).closest("tr").find(".moq").val(moq);
    });

    function validateItemSelect($select) {
        const selectedValue = $select.val();
        const currentRowId = $select.data('row');
        const $errorDiv = $select.next('.error-message');
        
        // Reset error state
        $select.removeClass('is-invalid');
        $errorDiv.hide().text('');
        
        if (selectedValue === '') {
            return true;
        }
        
        // Check for duplicates
        const isDuplicate = checkDuplicate(selectedValue, currentRowId);
        
        if (isDuplicate) {
            $select.addClass('is-invalid');
            alert("Item sudah dipilih!");
            $select.val("")
            return false;
        }
        
        return true;
    }

    function checkDuplicate(value, currentRowId) {
        let duplicateFound = false;
        
        $('.product-select').each(function() {
            const $select = $(this);
            const rowId = $select.data('row');
            
            if (rowId !== currentRowId && $select.val() === value) {
                duplicateFound = true;
                return false; // break loop
            }
        });
        
        return duplicateFound;
        }

    $(".item_table").on(
        "input",
        ".price, .qty, .discount, .vat_percentage",
        function () {
            calculateTotal();
        }
    );

    $("#tax_rate").on("input", function () {
        calculateTotal();
    });

    $(".item_table").on("click", ".delete_row", function () {
        $(this).closest("tr").remove();
        calculateTotal();
    });

    calculateTotal();

    $(document).on("click", "#add_button", function (e) {
        $(".item_table tbody").empty();
    });

    $(document).on("click", ".edit", function (e) {
        var id = this.dataset.id;
        $.ajax({
            type: "GET",
            url: base_url + "pr/" + id,
            success: function (data) {
                var data = data.data;

                $("[name=id]").val(data.id);
                $("[name=trans_date]").val(data.trans_date);
                $("[name=flag_type]").val(data.flag_type);
                $("[name=flag_purpose]").val(data.flag_purpose);
                $("[name=prs_supplier_id]").val(data.prs_supplier_id);
                $("[name=gen_currency_id]").val(data.gen_currency_id);
                $("[name=flag_status]").val(data.flag_status);
   
                $("[name=prs_supplier_id]").change();
               

            fetchSkuMaster(data.prs_supplier_id)
                .then((skuMaster) => {                 
                $(".item_table tbody").empty();
                rowCount = 1;
                for (let index = 0; index < data.items.length; index++) {
                            const item = data.items[index];
                            let sku_item = "";
                            skuMaster.forEach((datas) => {   
                                const isSelected = item.sku_id ==  datas.sku_pk_id ? "selected" : ""
                                sku_item +=
                                    `<option 
                                    ${isSelected}
                                    sku_description="` +
                                    datas.sku_name +
                                    `" sku_prefix="` +
                                    datas.sku_id +
                                    `"  price="` +
                                    datas.price +
                                    `" value="` +
                                    datas.sku_pk_id +
                                    `" spec_code="` +
                                    datas.sku_specification_code +
                                    `" >` +
                                    datas.sku_id +
                                    " - " +
                                    datas.sku_name +
                                    `</option>`;
                            });
                            const newRow =
                                `
                    <tr>
                        <td>${rowCount}</td>
                        <td>
                            <select required name="flag_type_detail[]" class="form-control item_sku">
                                <option value="">
                                    -- Pick Purchase Item Type --
                                    <option ${item.flag_type == 1 ? `selected` : ``} value="1"> New Order </option>
                                    <option ${item.flag_type == 2 ? `selected` : ``} value="2"> Addition </option>
                                    <option ${
                                        item.flag_type == 3 ? `selected` : ``
                                    } value="3"> Replacement </option>
                                    <option ${item.flag_type == 4 ? `selected` : ``} value="4"> Services </option>
                                </option>
                        </td>
                        <td>
                            <select required name="sku_id[]" class="form-control item_sku product-select" data-row="${rowCount}">
                                <option value="">
                                    -- Select SKU --
                                </option>
                                ` +
                                sku_item +
                                `
                            </select>
                        </td>
                        <td><input type="number" class="price form-control" name="price[]" placeholder="Price" value="${Number(item.price_f).toFixed()}" required></td>
                        <td style='display:none'><input type="hidden" class="sku_prefix form-control" name="sku_prefix[]"></td>
                        <td style='display:none'><input type="hidden" class="sku_description form-control" name="sku_description[]"></td>
                        <td><input type="number" class="qty form-control" name="qty[]" value="${Number(item.qty).toFixed()}" placeholder="Qty" step="1" required></td>
                        <td><input type="date" class="form-control" name="req_date[]" placeholder="Req Date" value="${item.req_date}" step="0.01" required></td>
                        <td><input type="text" class="form-control" name="description_item[]" value=${item.description} placeholder="Description"></td>
                        <td><input type="hidden" class="total form-control" name="total[]" placeholder="Total" step="0.01" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete_row">x</button></td>
                    </tr>
                    `;

                        $(".item_table tbody").append(newRow);
                        rowCount++;
                }

                $("#edit_modal").modal("show");

                })
                .catch((err) => {
                    console.error("Error get Supplier:", err);
                });
            },
            error: function (err) {
                debugger;
            },
        });

    });

    
    function fetchSkuMaster(supplier_id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: base_url + "sku-pricelist/api/by",
                data: {
                    prs_supplier_id: supplier_id,
                },
                success: function (data) {
                    resolve(data.data);
                },
                error: function (err) {
                    console.error("Error fetching SKU master:", err);
                    reject(err);
                },
            });
        });
    }

// $(document).on('click', '.btn_submit_modal', function (e) {
//     e.preventDefault();
//     debugger;
//     let $modal = $(this).closest('.modal');
//     let $form = $modal.find('form');
//     let isValid = true;

//     $form.find('.error-message').remove(); 
//     $form.find('.is-invalid').removeClass('is-invalid');

//     $form.find('[required]').each(function () {
//         if (!$(this).val() || $(this).val().trim() === '') {
//             isValid = false;
//             $(this).addClass('is-invalid'); // Tambahkan kelas untuk styling error
//             $(this).after('<span class="error-message" style="color: red; font-size: 12px;">This field is required.</span>');
//         }
//     });
//     if (typeof is_using_item !== 'undefined' && is_using_item == true){
//     let item_table_id = $('#item_table');
//         if (item_table_id.length > 0) {
//             let tableRowCount = item_table_id.find('tbody tr').length;
//             if (tableRowCount === 0) {
//                 isValid = false;
//                 item_table_id.after('<span class="error-message" style="color: red; font-size: 12px;">The item table cannot be empty.</span>');
//             }
//         }
//     }
    
//     if (!isValid) {
//         return false;
//     }
    
//     if($('[name="supplier[]"]').val() != $('#supplier_select').val()){
//         alert('Maaf supplier tidak sama dengan item yang dipilih');
//         return false;
//     }

//     $form.submit();
//     });
    
    $(document).on("click", ".btn_detail", function (e) {
        var table = $("#table-pr").DataTable();
        var row = table.row($(this).closest("tr"));
        var data = row.data();

        // Tampilkan data header di modal
        $("#detail_supplier").text(data.supplier);
        $("#detail_date").text(data.trans_date);
        $("#detail_description").text(data.description);
        $("#detail_status").text(data.transaction_status);
        $("#detail_doc_num").text(data.doc_num);
        $("#detail_pr_purpose").text(data.transaction_purpose);

        console.log(data);
        debugger;
        var id = this.dataset.id;
        $.ajax({
            type: "GET",
            url: base_url + "pr/" + id+"/detail",
            success: function (data) {
                var data = data.data;
                $("#detail_table tbody").empty();
                for (let index = 0; index < data.items.length; index++) {
                    const newRow = `
                        <tr>
                            <td>${data.items[index].sku_id}</td>
                            <td>${data.items[index].sku_name}</td>
                            <td>${data.items[index].spec_code}</td>
                            <td>${data.items[index].req_date}</td>
                            <td>${data.items[index].item_type}</td>
                            <td>${data.items[index].sku_unit}</td>
                            <td>${data.items[index].val_price}</td>
                            <td>${data.items[index].qty}</td>
                            <td>${data.items[index].val_total}</td>
                            <td>${data.items[index].item_status}</td>
                            <td>${data.items[index].description}</td>
                        </tr>
                    `;

                    $("#detail_table tbody").append(newRow);
                }

                $("#detail_modal").modal("show");
            },
            error: function (err) {
                debugger;
            },
        });
    });
}
