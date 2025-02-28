<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.approval_style.php
 * Type:     function
 * Name:     approval_style
 * Purpose:  承認権限レイアウトを表示する
 *
 *  @param  string  $approval
 *  @param  string  $val
 * -------------------------------------------------------------
 */
function smarty_function_approval_style($params, &$smarty)
{
    extract($params);
    // judge
    $is_approval = ApprovalCheck::is_approval($approval, $val);
    // set
    $text = $is_approval ? "&#10004;" : "";
    return $text;
}
?>