<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.auth_style.php
 * Type:     function
 * Name:     auth_style
 * Purpose:  権限レイアウトを表示する
 *
 *  @param  string  $authval
 *  @param  string  $val
 * -------------------------------------------------------------
 */
function smarty_function_auth_style($params, &$smarty)
{
    extract($params);
    // judge
    $is_auth = AuthCheck::is_auth($authval, $val);
    // set
    $text = $is_auth ? "&#10004;" : "";
    return $text;
}
?>