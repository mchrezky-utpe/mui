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

	$('.val_subtotal, .val_pph23, .val_discount, .val_total').on('input',function() {
		calc();
	});

	$('.is_ppn').on('change',function() {
		calc();
	});

	$('.trans_date').on('change',function() {
		$(".item_table tbody").empty();
	});

	function calc(){
		const tax_rate = parseFloat($('#tax_rate').val()) || 1;
		const tax_masters = JSON.parse($('[name=tax_master]').val());
		let term_ppn = 0;
		if($('[name=is_ppn]').prop('checked')){
			term_ppn = Number(tax_masters.find(a => a.prefix == "PPN").value);
			$('[name=val_vat]').val(term_ppn);
		}
		const sub_total = Number($('.val_subtotal').val());
		const ppn = sub_total * (term_ppn/100);
		const pph23 = $('.val_pph23').val();
		const discount = $('.val_discount').val();

		const total = sub_total + ppn - pph23 - discount;
		$('[name=val_total]').val(total);
		$('[name=val_vat]').val(ppn);
	}
}