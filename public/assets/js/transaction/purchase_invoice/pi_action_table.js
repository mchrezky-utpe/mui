import {
	skuMaster, table_pi
} from './pi_global_variable.js';

export function handleActionTable() {


	$('#btn-filter').click(function() {
		table_pi.ajax.reload(); 
	});

	$(".add_row").on("click", function() {
		const trans_date = $('[name=trans_date]').val();
		const prs_supplier_id = $('[name=prs_supplier_id]').val();;
		
		if(trans_date == null){
			alert("Pilih invoice date!");
			return;
		}
		if(prs_supplier_id == ""){
			alert("Pilih Supplier");
			return;
		}

 		$.ajax({
            type: "GET",
            url: base_url + "pi/po",
			data: {
				trans_date: trans_date,
				prs_supplier_id: prs_supplier_id,
			},
            success: function (response) {
				var data = response.data;
			
				$(".item_table tbody").empty();
				for (let index = 0; index < data.length; index++) {
					const item = data[index];
					const newRow =
						`
							<tr>
								<td>
								<input value="${item.trans_po_id}" type="hidden" name="trans_po_id[]" />
								${item.po_doc_num}
								</td>
								<td><input type="checkbox" name="is_check[]" /></td>
							</tr>`;

					$(".item_table tbody").append(newRow);
				}
            },
            error: function (err) {
                debugger;
            },
        });
	});


	$(document).on("click", ".edit", function (e) {
        var id = this.dataset.id;
		$.ajax({
			type: "GET",
			url: base_url + "pi/" + id,
			success: function (data) {
				var data = data.data;
				if(data.vat_f != null && Number(data.vat_f) > 0){
					$("[name=is_ppn]").prop('checked',true);
				}
				$("[name=id]").val(data.id);
				$("[name=doc_number]").val(data.doc_num);
				$("[name=manual_id]").val(data.manual_id);
				$("[name=gen_terms_detail_id]").val(data.gen_terms_detail_id);
				$("[name=flag_phase_payment]").val(data.flag_phase_payment);
				$("[name=gen_currency_id]").val(data.gen_currency_id);
				$("[name=val_subtotal]").val(Number(data.subtotal_f).toFixed());
				$("[name=val_pph23]").val(Number(data.pph23_f).toFixed());
				$("[name=val_discount]").val(Number(data.discount_f).toFixed());
				$("[name=val_total]").val(Number(data.total_f).toFixed());
				reinitCalcForNewElements();
				$("#edit_modal").modal("show");
			},
			error: function (err) {
				debugger;
			},
		});

    });
	
    $(document).on("click", ".checkAndVerify", function (e) {
        var id = this.dataset.id;
        $.ajax({
            type: "GET",
            url: base_url + "pi/" + id +"/item/check",
            success: function (data) {
				var data = data.data;
			
				$(".item_check_table tbody").empty();
				for (let index = 0; index < data.length; index++) {
					const item = data[index];
					const newRow =
						`<tr>
							<td>
								${item.trans_date}
							</td>
							<td>
								<input value="${item.trans_po_detail_id}" type="hidden" name="trans_po_detail_id[]" />
								<input value="${item.trans_po_id}" type="hidden" name="trans_po_id[]" />
								${item.doc_num}
							</td>
							<td>
								${item.do_doc_num}
							</td>
							<td>
								${item.sku_prefix}
							</td>
							<td>
								${item.sku_description}
							</td>
							<td>
								${item.sku_type}
							</td>
							<td>
								${item.qty}
							</td>
							<td><input type="checkbox" name="is_check[]" /></td>
						</tr>`;

					$(".item_check_table tbody").append(newRow);
				}

                $("#item_check_modal").modal("show");
            },
            error: function (err) {
                debugger;
            },
        });

	});

	$('.val_subtotal, .val_pph23, .val_discount, .val_total').on('input',function() {
		calc();
	});

	$('.is_ppn').on('change',function() {
		calc();
	});

	$('.trans_date').on('change',function() {
		$(".item_table tbody").empty();
	});

	function calc(triggerElement){
    // Cari row terdekat dari element yang memicu
    const $context = triggerElement ? $(triggerElement) : $('.val_subtotal').first();
    const $row = $context.closest('.row-calc'); // Ganti dengan class row Anda
    
    const tax_rate = parseFloat($row.find('.tax_rate').val()) || 1;
    const tax_masters = JSON.parse($('[name=tax_master]').val());
    let term_ppn = 0;
    
    if($row.find('[name=is_ppn]').prop('checked')){
        term_ppn = Number(tax_masters.find(a => a.prefix == "PPN").value);
        $row.find('[name=val_vat]').val(term_ppn);
    }
    
    const sub_total = Number($row.find('.val_subtotal').val()) || 0;
    const ppn = sub_total * (term_ppn/100);
    const pph23 = Number($row.find('.val_pph23').val()) || 0;
    const discount = Number($row.find('.val_discount').val()) || 0;

    const total = sub_total + ppn - pph23 - discount;
    $row.find('[name=val_total]').val(total);
    $row.find('[name=val_vat]').val(ppn);
}

function reinitCalcForNewElements() {
    // Hapus existing event listeners dan tambahkan yang baru
    $('.val_subtotal, .val_pph23, .val_discount, [name=is_ppn]').off('change input.calc-event');
    
    // Tambahkan event listeners dengan namespace
    $('.val_subtotal, .val_pph23, .val_discount, [name=is_ppn]').on('change.input.calc-event input.calc-event', function() {
        calc(this);
    });
}
	


    $(document).ready(function() {

        // Expand row on button click
        $('#table-pi tbody').on('click', '.view-details', function() {
            var tr = $(this).closest('tr');
            var row = table_pi.row(tr);
            var id = $(this).data('id');

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.ajax({
                    url: '/pi/'+id+'/items',
                    type: 'GET',
                    success: function(data) {
						let body = "";
						data.data.forEach(obj => {
							body += 
							`<tr>
								<td>${obj.trans_date}</td>
								<td>${obj.po_doc_num}</td>
								<td>${obj.do_doc_num}</td>
								<td>${obj.sku_prefix}</td>
								<td>${obj.sku_name}</td>
								<td>${obj.sku_material_type}</td>
								<td>${obj.sku_material_type}</td>
								<td>${obj.qty}</td>
								<td>${obj.currency}</td>
								<td>${obj.price_f}</td>
								<td>${obj.total_f}</td>
								<td><span class="fa fa-check"></span></td>
							</tr>`
						});
                        var detailHtml = `
                            <div class="p-3 bg-light">
                                <table class="table table-sm">
                                    <tr>
										<th>Date</th>
										<th>Po Number</th>
										<th>Do Number</th>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>Item Type</th>
										<th>Unit</th>
										<th>Qty</th>
										<th>Curr</th>
										<th>Price</th>
										<th>Amount</th>
										<th>Check</th>
									</tr>
									`+
										body
									+`
                                </table>
                            </div>
                        `;
                        row.child(detailHtml).show();
                        tr.addClass('shown');
                    }
                });
            }
        });
    });


}