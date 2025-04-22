<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.yen_format.php
 * Type:     function
 * Name:     yen_format
 * Purpose:  表示フラグの色分け
 *
 *  @param  string  $value   表示フラグ
 * -------------------------------------------------------------
 */
function smarty_function_yen_format($params, &$smarty)
{
    $ret = "";
    extract($params);

    if (is_empty($value)) {
        return $ret;
    }
    $ret .= "&#165;&nbsp;";
    $ret .= number_format($value);
    return $ret;
}
?>