<?php

use App\Models\Setting;
use App\Models\Contacts;

function setting()
{
    return Setting::first();
}

function contact()
{
    return Contacts::first();
}

function is_favorite($id)
{
    if (auth()->guard('student')->user() != null) {
        $flag = DB::table('favorites')->where('student_id', auth()->guard('student')->user()->id)->where('facility_id', $id)->first();

        if ($flag != null) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function get_languages()
{
    return App\Models\Language::where('status', 'active')->get();
}

function get_currencies()
{
    return App\Models\Currency::where('active', 1)->get();
}

function lng($target, $key)
{
    $lang = LaravelLocalization::getCurrentLocaleNative();
    if ($lang == 'العربية') {
        return $target->$key;
    } else {
        $key = $key . '_en';
        return $target->$key;
    }
}

function convert2english($string)
{
    $newNumbers = range(0, 9);
    // 1. Persian HTML decimal
    $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
    // 2. Arabic HTML decimal
    $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
    // 3. Arabic Numeric
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    // 4. Persian Numeric
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

    $string = str_replace($persianDecimal, $newNumbers, $string);
    $string = str_replace($arabicDecimal, $newNumbers, $string);
    $string = str_replace($arabic, $newNumbers, $string);
    return str_replace($persian, $newNumbers, $string);
}

function seo()
{
    return DB::table('seosettings')->first();
}
