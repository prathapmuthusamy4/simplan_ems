<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.convert_ord.php
 * Type:     modifier
 * Name:     convert_ord
 * Purpose:  文字をASCII値に変換する
 *
 *
 *  sample:
 *  <code>
 *  {"info@threet.co.jp"|convert_ord"}
 *  </code>
 *  <code>
 *  &#111;
 *  </code>
 *
 *  @param  string  $string  対象文字列
 *  @return string  $string  変換文字列
 * -------------------------------------------------------------
 */
function smarty_modifier_convert_ord($str)
{
    $ret = "";
    if ($str === "" || $str == null) {
        return $ret;
    }
    
    for ($i = 0; $i < strlen($str); $i++) {
        $var = (rand() % 3 == 0) ? $str[$i] : "&#" . ord($str[$i]) . ";";
        $ret .= $var;
    }    
    return $ret;
}
?>