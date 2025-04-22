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
function smarty_modifier_add_minus($value)
{
    $ret = NULL;
    if (!is_empty($value)) {
        $ret = -$value;
    }

    return $ret;
}
?>