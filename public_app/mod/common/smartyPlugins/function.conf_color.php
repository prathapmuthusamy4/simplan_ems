<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.conf_color.php
 * Type:     function
 * Name:     conf_color
 * Purpose:  確認フラグの色分け
 *
 *  @param  string  $value   確認フラグ
 * -------------------------------------------------------------
 */
function smarty_function_conf_color($params, &$smarty)
{
    $ret = "";
    extract($params);

    $color = "";
    $text  = t_array_value($value, unserialize(STATUS_CONF_LIST));
    switch ($value) {
        // 未確認
        case STATUS_CONF_OFF :
            $color = "red";
            break;
        // 確認済
        case STATUS_CONF_ON :
            $color = "#000000";
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