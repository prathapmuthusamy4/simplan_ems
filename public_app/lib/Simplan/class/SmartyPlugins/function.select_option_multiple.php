<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.select_option_multiple.php
 * Type:     function
 * Name:     select_option_multiple
 * Purpose:  複数選択タイプのオプションボックスを作成する
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_function_select_option_multiple($params, &$smarty)
{
    extract($params);

    $ret = "";
    $target = is_array($list) ? $list : array();
    foreach ($target as $key => $val) {
        $selected = "";
        foreach ($value as $k => $v) {
            if ((string)$key == (string)$v) {
                $selected = " selected";
                break;
            }
        }
        $ret = $ret . "<option value=\"$key\"$selected>$val</option>";
    }

    return $ret;
}
?>