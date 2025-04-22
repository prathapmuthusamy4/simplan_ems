<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.array_value_color
 * Type:     function
 * Name:     array_value
 * Purpose:  指定されたキーから値を取得しカラータグを付ける
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_array_value_color($params, &$smarty)
{
    extract($params);

    $ret = "";
    if (!is_array($list) && !is_array($color)) {
        return $ret;
    }
    $value = t_array_value($key, $list);
    $col   = t_array_value($key, $color);
    $ret = "<font color=\"$col\">$value</font>";

    return $ret;
}
?>