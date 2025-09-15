import {
	calc_subtotal,
	calc_discount,
	calc_vat
} from '../../common/calculate.js';

export function calculateTotal() {
	let sub_total = 0;
	let discount_total = 0;
	let vat_total = 0;

	$('#item_table tbody tr').each(function() {
		const result = calc_per_row(this);
		sub_total += result.sub_total;
		discount_total += result.discount;
		vat_total += result.vat;
	});

	const after_discount = sub_total - discount_total;
	const total = after_discount + vat_total;

	$('#sub_total').val(sub_total.toFixed(2));
	$('#discount_total').val(discount_total.toFixed(2));
	$('#after_discount').val(after_discount.toFixed(2));
	$('#vat').val(vat_total.toFixed(2));
	$('#total').val(total.toFixed(2));
}

function calc_per_row(row) {
	const tax_rate = parseFloat($('#tax_rate').val()) || 1;
	const price = parseFloat($(row).find('.price').val()) || 0;
	const qty = parseFloat($(row).find('.qty').val()) || 0;
	const discount = parseFloat($(row).find('.discount').val()) || 0;
	const vat_percentage = parseFloat($(row).find('.vat_percentage').val()) || 0;

	const result_sub_total = calc_subtotal(tax_rate, qty, price);
	const result_discount = calc_discount(result_sub_total.sub_total_f, result_sub_total.sub_total_f, discount);
	const result_vat = calc_vat(result_discount.after_discount_f, result_discount.after_discount_d, vat_percentage);


	const sub_total = result_sub_total.sub_total_f;
	const discount_value = result_discount.discount_f;
	const after_discount = result_discount.after_discount_f;
	const vat = result_vat.vat_f;
	const total = result_vat.total_f;

	$(row).find('.sub_total').val(sub_total.toFixed(0));
	$(row).find('.after_discount').val(after_discount.toFixed(0));
	$(row).find('.total').val(total.toFixed(0));
	return {
		sub_total: sub_total,
		discount: discount_value,
		after_discount: after_discount,
		vat: vat,
		total: total
	};
}