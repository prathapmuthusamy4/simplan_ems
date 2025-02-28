<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.abstract_mail_style_2.php
 * Type:     function
 * Name:     abstract_mail_style_2
 * Purpose:  マッチングパターンレイアウトを表示する
 *
 *  @param  string  $val    パターン値
 * -------------------------------------------------------------
 */
function smarty_function_abstract_mail_style_2($params, &$smarty)
{
        extract($params);

        $pr = "";
        if (is_empty($val)) {
            return $pr;
        }
        $tmp = t_explode($val, ",");
        $cnt = count($tmp);
        for ($i=0; $i<$cnt; $i++) {
            $pr .= t_array_value($tmp[$i], unserialize(STATUS_ABSTRACT_LIST));
            if ($i != ($cnt-1)) {
                $pr .= ",";
            }
        }
        // make sentence
        return $pr;
}
?>