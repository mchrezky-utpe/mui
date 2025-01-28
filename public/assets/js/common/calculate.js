// sub total 
export function calc_subtotal(exchange_rate, qty, price) {
    const sub_total_f = qty * price;
    const sub_total_d = qty * price * exchange_rate;
    return {
        sub_total_f: sub_total_f,
        sub_total_d: sub_total_d,
    };
}

// discount 
export function calc_discount(sub_total_f, sub_total_d, discount_percentage) {
    const discount_f = (sub_total_f * discount_percentage)/100;
    const after_discount_f = sub_total_f - discount_f;
    
    const discount_d = (sub_total_d * discount_percentage)/100;
    const after_discount_d = sub_total_d - discount_d;

    return {
        discount_f: discount_f,
        after_discount_f: after_discount_f,
        discount_d: discount_d,
        after_discount_d: after_discount_d,
    };
}

// vat 
export function calc_vat(after_discount_f, after_discount_d, vat_percentage) {
    const vat_f = (after_discount_f * vat_percentage)/100;
    const total_f = after_discount_f + vat_f;

    const vat_d = (after_discount_d * vat_percentage)/100;
    const total_d = after_discount_d + vat_d;

    return {
        vat_f: vat_f,
        total_f: total_f,
        vat_d: vat_d,
        total_d: total_d,
    };
}

