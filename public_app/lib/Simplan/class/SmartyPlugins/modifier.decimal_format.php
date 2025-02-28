<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.decimal_format.php
 * Type:     modifier
 * Name:     decimal_format
 * Purpose:  フォーマット済み文字列
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_modifier_decimal_format($string, $decimals = 2)
{
    if ($string === "" || $string == null) {
        return "";
    }
    if (ctype_digit($string)) {
        return number_format($string);
    }
    return number_format($string, $decimals);
}
?>