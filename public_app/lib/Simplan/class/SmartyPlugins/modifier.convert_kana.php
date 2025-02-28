<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.convert_kana.php
 * Type:     modifier
 * Name:     convert_kana
 * Purpose:  フォーマット済み文字列
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_modifier_convert_kana($string, $option)
{
    if ($string === "" || $string == null) {
        return "";
    }
    $ret = mb_convert_kana($string, $option);
    return $ret;
}
?>