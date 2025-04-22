<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.array_value
 * Type:     function
 * Name:     array_value
 * Purpose:  指定されたキーから値を返却する
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_array_value($params, &$smarty)
{
    extract($params);

    return t_array_value($key, $list);
}
?>