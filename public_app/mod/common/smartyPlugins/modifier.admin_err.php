<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.admin_error.php
 * Type:     modifier
 * Name:     error message
 * Purpose:  管理者用画面のエラーメッセージを返す
 *
 * -------------------------------------------------------------
 */
function smarty_modifier_admin_err($string)
{
    $ret = "";
    if ($string != "") {
        $ret = "<br /><font color=\"red\">$string</font>";
    }

    return $ret;
}
?>