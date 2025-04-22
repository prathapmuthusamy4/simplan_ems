<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.explode_array_value.php
 * Type:     function
 * Name:     explode_array_value
 * Purpose:  
 *
 *  @param  string  $value
 *  @param  string  $list
 * -------------------------------------------------------------
 */
function smarty_function_explode_array_value($params, &$smarty)
{
    $ret = "";
    extract($params);

    if (is_empty($value)) {
        return $ret;
    }
    $arr = t_explode($value, ",");
    if (!is_empty($arr)) {
        sort($arr);
        for ($i=0; $i<count($arr); $i++) {
            $v = $arr[$i];
            $text = t_array_value($v, $list);
            $ret .= "{$text}";
            $ret .= ",&nbsp;&nbsp;";
        }
    }
    return $ret;
}
?>