<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.url_convert_anchor
 * Type:     function
 * Name:     add_a_tag
 * Purpose:  <a>タグを追加する
 *
 *  @param  array   $params    入力値
 *  @return String  連想配列に対する値
 * -------------------------------------------------------------
 */
function smarty_function_url_convert_anchor($params, &$smarty)
{
    extract($params);

    if (is_empty($var)) {
        return $var;
    }
    return preg_replace("/http:\/\/(.*?)\/\.?$/", "<a target=\"_blank\" href=\"http://$1\" style=\"text_decoration: underline;\">http://$1</a>", $var);
}
?>