<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.admin_error_nobr.php
 * Type:     modifier
 * Name:     error message
 * Purpose:  管理者用画面のエラーメッセージを返す
 *
 * -------------------------------------------------------------
 */
function smarty_modifier_admin_err_nobr($string, $add='')
{
    $ret = "";
    if ($string != "") {
        $ret = "<font color=\"red\">$string</font>";
    }

    return $ret;
}
?>