<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.disp_color.php
 * Type:     function
 * Name:     disp_color
 * Purpose:  表示フラグの色分け
 *
 *  @param  string  $value   表示フラグ
 * -------------------------------------------------------------
 */
function smarty_function_disp_color($params, &$smarty)
{
    $ret = "";
    extract($params);

    $color = "";
    $text  = t_array_value($value, unserialize(STATUS_DISP_LIST));
    switch ($value) {
        // 表示
        case STATUS_DISP_OFF :
            $color = "#000000";
            break;
        // 非表示
        case STATUS_DISP_ON :
            $color = "silver";
            break;
        default :
            $color = "#000000";
            $text  = "";
            break;
    }

    $ret .= "<font color=\"{$color}\">{$text}</font>";
    return $ret;
}
?>