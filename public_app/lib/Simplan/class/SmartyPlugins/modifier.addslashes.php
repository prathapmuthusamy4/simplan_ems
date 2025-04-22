<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.addslashes.php
 * Type:     modifier
 * Name:     addslashes
 * Purpose:  文字列をスラッシュでクォートする
 *
 *
 *  sample:
 *  <code>
 *  {"info@threet.co.jp"|addslashes"}
 *  </code>
 *  <code>
 *  &#111;
 *  </code>
 *
 *  @param  string  $string  対象文字列
 *  @return string  $string  変換文字列
 * -------------------------------------------------------------
 */
function smarty_modifier_addslashes($str)
{
    $ret = "";
    if ($str === "" || $str == null) {
        return $ret;
    }
    
    $ret = addslashes($str);
    return $ret;
}
?>