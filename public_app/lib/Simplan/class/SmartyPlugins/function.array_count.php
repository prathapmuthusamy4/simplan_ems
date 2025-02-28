<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.array_count.php
 * Type:     modifier
 * Name:     array_count
 * Purpose:  配列を数えます
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_function_array_count($params, &$smarty)
{
    extract($params);

    if (!is_array($list)) {
        return 0;
    }
    return count($list);
}
?>