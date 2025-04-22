<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.function.radio_option_ex.php
 * Type:     function
 * Name:     radio_option
 * Purpose:  ラジオボックスを作成する
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_function_radio_option_ex($params, &$smarty)
{
    extract($params);

    $ret = "";
    $target = is_array($list) ? $list : array();
    foreach($target as $k => $v) {
        $selected = ((string)$k == (string)$value) ? " checked" : "";
        if (!is_empty($ret)) {
            $ret = $ret . "&nbsp;";
        }
        $ret = $ret
            . "<input type=\"radio\" name=\"{$name}\" id=\"{$name}{$k}\" value=\"{$k}\"{$selected} class=\"radio-btn\" />"
            . "<label for=\"{$name}{$k}\"><span class=\"radio-btn-txt\">{$v}</span></label>&nbsp;";
    }

    return $ret;
}
?>