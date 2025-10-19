import {
	calc_subtotal,
	calc_discount,
	calc_vat
} from '../../common/calculate.js';

function calc() {
	const tax_rate = parseFloat($('#tax_rate').val()) || 1;
	const tax_masters = JSON.parse($('[name=tax_master]').val());
	const term_ppn = tax_masters.find(a => a.prefix == "PPN");
	const sub_total = $('.val_subtotal').val();
	const ppn = sub_total * (term_ppn/100);
	const pph23 = $('.val_pph23').val();
	const discount = $('.val_discount').val();

	const total = sub_total + ppn + pph23 - discount;
	$('[name=val_total]').val(total);
}