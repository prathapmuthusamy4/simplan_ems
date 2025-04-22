<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.admin_attention.php
 * Type:     modifier
 * Name:     attention message
 * Purpose:  管理者用画面の注意メッセージを返す
 *
 * -------------------------------------------------------------
 */
function smarty_modifier_admin_attention($string)
{
    $ret = "";
    if ($string != "") {
        $ret = "<br /><font color=\"blue\">$string</font>";
    }

    return $ret;
}
?>