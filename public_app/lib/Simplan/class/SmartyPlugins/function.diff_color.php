<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.diff_color
 * Type:     function
 * Name:     diff_color
 * Purpose:  
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_diff_color($params, &$smarty)
{
    extract($params);

    $ret = "";
    if (is_empty($value)) {
        return $ret;
    }
    if ($def != $value) {
        $ret = "<font color=\"#FF0000\">$value</font>";
        return $ret;
    }
    $ret = $value;
    return $ret;
}
?>