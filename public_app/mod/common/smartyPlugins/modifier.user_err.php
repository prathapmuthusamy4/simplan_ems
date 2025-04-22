<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.user_error.php
 * Type:     modifier
 * Name:     error message
 * Purpose:  ユーザ用画面のエラーメッセージを返す
 *
 * -------------------------------------------------------------
 */
function smarty_modifier_user_err($string)
{
    $ret = "";
    if ($string != "") {
        $ret = "<br /><font size=\"-2\" color=\"red\">$string</font>";
    }

    return $ret;
}
?>