<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.escape_decode.php
 * Type:     modifier
 * Name:     escape_decode
 * Purpose:  エスケープされた文字を戻す
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_modifier_escape_decode($string)
{
    $ret = $string;

    // target
    $value = array( "&amp;" => '&',
                    "&lt;" => '<',
                    "&gt;" => '>',
                    "&quot;" => '"',
                    "&rsquo" => "'",
                    "\\" => "",
                    );

    // 置換
    foreach ($value as $key => $val) {
        $ret = str_replace($key, $val, $ret);
    }

    return $ret;
}
?>