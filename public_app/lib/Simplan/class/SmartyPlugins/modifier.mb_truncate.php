<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.mb_truncate.php
 * Type:     modifier
 * Name:     mb_truncate
 * Purpose:  トランケートされた文字を戻す
 *
 *  @param  string  $string   文字列
 *  @param  string  $length   桁数
 *  @param  string  $etc      補足文字
 * -------------------------------------------------------------
 */
function smarty_modifier_mb_truncate($string, $length=80, $etc='...')
{

    if ($length == 0) {
        return "";
    }
    if (mb_strlen($string, "UTF-8") > $length) {
        $string = mb_substr($string, 0, $length, "UTF-8");
        return $string.$etc;
    } else {
        return $string;
    }
}
?>