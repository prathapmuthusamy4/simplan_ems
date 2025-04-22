<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.array_value_diff_color
 * Type:     function
 * Name:     array_value_diff_color
 * Purpose:  指定されたキーから値を返却する
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_array_value_diff_color($params, &$smarty)
{
    extract($params);

    $ret = t_array_value($key, $list);
    if (is_empty($key)) {
        return $ret;
    }
    if ($def != $key) {
        $ret = "<font color=\"#FF0000\">$ret</font>";
        return $ret;
    }
    return $ret;
}
?>