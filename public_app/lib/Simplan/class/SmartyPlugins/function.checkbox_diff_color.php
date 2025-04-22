<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.checkbox_diff_color.php
 * Type:     function
 * Name:     checkbox_diff_color
 * Purpose:  西暦から和暦に変換
 *
 *  @param  string  $date   日付
 * -------------------------------------------------------------
 */
function smarty_function_checkbox_diff_color($params, &$smarty)
{
    extract($params);

    $ret = "#000000";
    if (is_empty($value)) {
        return $ret;
    }
    if (!is_array($value)) {
        return $ret;
    }
    if (is_empty($def)) {
        return "#FF0000";
    }
    if (!is_array($def)) {
        return "#FF0000";
    }
    $tmp = array_diff($value, $def);
    if (!is_empty($tmp)) {
        $ret = "#FF0000";
    }
    return $ret;
}
?>