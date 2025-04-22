<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.strimwidth_ex.php
 * Type:     modifier
 * Name:     strimwidth
 * Purpose:  Firefox用にWBRタグを挿入する
 *
 *
 *  sample:
 *  <code>
 *  {"日本語です"|strimwidth:5"}
 *  </code>
 *  <code>
 *  日本語...
 *  </code>
 *
 *  @param  string  $string  対象文字列
 *  @param  int     $len     文字数
 *  @param  string  $psotfix 挿入文字列
 *  @return string  $string  文字数でカットし、挿入文字列を代入した対象文字列
 * -------------------------------------------------------------
 */
function smarty_modifier_strimwidth_ex($string, $len, $postfix = "...") {
    if ($string === "" || $string == null) {
        return "";
    }

    return mb_strimwidth($string, 0, $len, $postfix);

}
?>