<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.select_option.php
 * Type:     function
 * Name:     select_option
 * Purpose:  オプションボックスを作成する
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_function_select_option($params, &$smarty)
{
    extract($params);

    $ret = "";
    $target = is_array($list) ? $list : array();
    foreach($target as $k => $v) {
        $selected = ((string)$k == (string)$value) ? " selected" : "";
        $ret = $ret . "<option value=\"$k\"$selected>$v</option>";
    }

    return $ret;
}
?>