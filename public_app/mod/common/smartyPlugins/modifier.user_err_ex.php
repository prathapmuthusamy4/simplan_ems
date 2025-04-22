<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.user_error_ex.php
 * Type:     modifier
 * Name:     error message
 * Purpose:  ユーザ用画面のエラーメッセージを返す
 *
 * -------------------------------------------------------------
 */
function smarty_modifier_user_err_ex($string)
{
    $ret = "";
    if ($string != "") {
        $ret = "<font size=\"-2\" color=\"red\">$string</font>";
    }

    return $ret;
}
?>