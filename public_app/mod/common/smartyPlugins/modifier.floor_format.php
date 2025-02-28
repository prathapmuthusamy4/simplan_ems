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
function smarty_modifier_floor_format($value, $digit)
{
    $value = t_floor($value, $digit);
    return t_number_format_ex($value);
}
?>