<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class HelperCustom
{
    public static function generateTrxNo($prefix, $value)
    {
        return $prefix . str_pad($value, 4, '0', STR_PAD_LEFT);
    }

    public static function unformatNumber($number)
    {
        return floatval(preg_replace('/[^\d\.]+/', '', $number));
    }

    public static function formatDateTime($date)
    {
        return date('d-m-Y h:i:s', strtotime($date));
    }

    public static function formatDate($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public static function isValidAccess($privilege)
    {
        if (!in_array($privilege, Session::get('privileges'))) {
            return abort(401);
        }
    }
    
    public static function isExistsAccess($privilege)
    {
     return in_array($privilege, Session::get('privileges'));
    }
}
