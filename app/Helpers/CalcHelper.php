<?php

namespace App\Helpers;

class CalcHelper
{
    /**
     * Calculate Subtotal
     *
     * @param float $exchange_rate
     * @param float $qty
     * @param float $price
     * @return array
     */
    public static function calcSubtotal($exchange_rate, $qty, $price)
    {
        $sub_total_f = $qty * $price;
        $sub_total_d = $qty * $price * $exchange_rate;

        return [
            'sub_total_f' => $sub_total_f,
            'sub_total_d' => $sub_total_d,
        ];
    }

    /**
     * Calculate Discount
     *
     * @param float $sub_total_f
     * @param float $sub_total_d
     * @param float $discount_percentage
     * @return array
     */
    public static function calcDiscount($sub_total_f, $sub_total_d, $discount_percentage)
    {
        $discount_f = ($sub_total_f * $discount_percentage) / 100;
        $after_discount_f = $sub_total_f - $discount_f;

        $discount_d = ($sub_total_d * $discount_percentage) / 100;
        $after_discount_d = $sub_total_d - $discount_d;

        return [
            'discount_f' => $discount_f,
            'after_discount_f' => $after_discount_f,
            'discount_d' => $discount_d,
            'after_discount_d' => $after_discount_d,
        ];
    }

    /**
     * Calculate VAT
     *
     * @param float $after_discount_f
     * @param float $after_discount_d
     * @param float $vat_percentage
     * @return array
     */
    public static function calcVat($after_discount_f, $after_discount_d, $vat_percentage)
    {
        $vat_f = ($after_discount_f * $vat_percentage) / 100;
        $total_f = $after_discount_f + $vat_f;

        $vat_d = ($after_discount_d * $vat_percentage) / 100;
        $total_d = $after_discount_d + $vat_d;

        return [
            'vat_f' => $vat_f,
            'total_f' => $total_f,
            'vat_d' => $vat_d,
            'total_d' => $total_d,
        ];
    }
}
