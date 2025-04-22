<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.number_format.php
 * Type:     modifier
 * Name:     number_format
 * Purpose:  フォーマット済み文字列
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_modifier_number_format($string, $num=0)
{
    if ($string === "" || $string == null) {
        return "";
    }
    return number_format($string, $num);
}
?>