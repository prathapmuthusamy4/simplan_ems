<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.function.radio_option.php
 * Type:     function
 * Name:     radio_option
 * Purpose:  ラジオボックスを作成する
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_function_radio_option($params, &$smarty)
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
            . "<input type=\"radio\" name=\"{$name}\" id=\"{$name}{$k}\" value=\"{$k}\"{$selected}/>"
            . "&nbsp;<label for=\"{$name}{$k}\">{$v}</label>&nbsp;";
    }
    return $ret;
}
?>