<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.display_choice_value.php
 * Type:     function
 * Name:     display_choice_value
 * Purpose:  複数選択を表示
 *
 *  @param  string  $key    選択した値
 *  @param  array   $list   表示する値
 * -------------------------------------------------------------
 */
function smarty_function_display_choice_value($params, &$smarty)
{
    $ret = "";
    extract($params);

    // セパレータ
    $sep = ',';
    if (isset($separate)) {
        $sep = $separate;
    }

    if (isset($key) && isset($list) && !is_empty($key) && is_array($list)) {
        // 文字列を配列に変更
        $array = explode($sep, $key);
        foreach ((array)$array as $value) {
            if (isset($list[$value])) {
                if (!is_empty($ret)) {
                    $ret .= ', ';
                }
                $ret .= $list[$value];
            }
        }
    }
    return $ret;
}
?>