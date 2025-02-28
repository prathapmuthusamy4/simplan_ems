<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sex_color.php
 * Type:     function
 * Name:     sex_color
 * Purpose:  性別の色分け
 *
 *  @param  string  $value   性別
 * -------------------------------------------------------------
 */
function smarty_function_sex_color($params, &$smarty)
{
    $ret = "";
    extract($params);

    $color = "";
    $text  = t_array_value($value, unserialize(STATUS_SEX_LIST));
    switch ($value) {
        // 女性
        case STATUS_SEX_LADY :
            $color = "red";
            break;
        // 男性
        case STATUS_SEX_MAN :
            $color = "blue";
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