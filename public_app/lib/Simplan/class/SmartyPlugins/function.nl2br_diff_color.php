<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.nl2br_diff_color
 * Type:     function
 * Name:     nl2br_diff_color
 * Purpose:  
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_nl2br_diff_color($params, &$smarty)
{
    extract($params);

    $ret = "";
    if (is_empty($value)) {
        return $ret;
    }
    if ($def != $value) {
        $tmp = nl2br($value);
        $ret = "<font color=\"#FF0000\">$tmp</font>";
        return $ret;
    }
    $ret = nl2br($value);
    return $ret;
}
?>