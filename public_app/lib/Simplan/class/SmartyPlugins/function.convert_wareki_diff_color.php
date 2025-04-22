<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.convert_wareki_diff_color.php
 * Type:     function
 * Name:     convert_wareki_diff_color
 * Purpose:  西暦から和暦に変換
 *
 *  @param  string  $date   日付
 * -------------------------------------------------------------
 */
function smarty_function_convert_wareki_diff_color($params, &$smarty)
{
    extract($params);

    $ret = "";
    $ymd = t_wareki($y, $m, $d);
    if (is_empty($dy) || is_empty($dm) || is_empty($dd)) {
        return $ret = "<font color=\"#FF0000\">$ymd</font>";
    }
    $dymd = t_wareki($dy, $dm, $dd);
    if ($dymd != $ymd) {
        $ret = "<font color=\"#FF0000\">$ymd</font>";
        return $ret;
    }
    return $ret = $ymd;
}
?>