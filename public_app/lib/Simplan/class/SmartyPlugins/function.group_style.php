<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.group_style.php
 * Type:     function
 * Name:     group_style
 * Purpose:  マッチンググループレイアウトを表示する
 *
 *  @param  string  $val    グループ値
 * -------------------------------------------------------------
 */
function smarty_function_group_style($params, &$smarty)
{
        extract($params);

        $pr = "";
        if (is_empty($val)) {
            return $pr;
        }
        $tmp = t_explode($val, ",");
        $cnt = count($tmp);
        for ($i=0; $i<$cnt; $i++) {
            $pr .= t_array_value($tmp[$i], unserialize(STATUS_MATCHING_GROUP_LIST));
            if ($i != ($cnt-1)) {
                $pr .= "\n";
            }
        }
        // make sentence
        return $pr;
}
?>