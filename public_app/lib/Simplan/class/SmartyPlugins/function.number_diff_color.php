<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.number_diff_color.php
 * Type:     function
 * Name:     number_diff_color
 * Purpose:  
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_number_diff_color($params, &$smarty)
{
    extract($params);

    $ret = "";
    if (is_empty($value)) {
        return $ret;
    }
    if ($def != $value) {
        $tmp = number_format($value);
        $ret = "<font color=\"#FF0000\">$tmp</font>";
        return $ret;
    }
    $ret = number_format($value);
    return $ret;
}
?>