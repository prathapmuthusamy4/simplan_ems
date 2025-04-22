<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.admin_page_info.php
 * Type:     function
 * Name:     admin_page_info
 * Purpose:  管理者用画面の件数タグを出力する
 *
 *  @param  string  $total   トータル数
 *  @param  string  $current 現在のページ番号
 *  @param  string  $max     1ページあたりの最大値
 * -------------------------------------------------------------
 */
function smarty_function_admin_page_navi($params, &$smarty)
{
    $pr = "";
    extract($params);

    // check
    if (!isset($info['total_count']) && !isset($info['offset']) &&
        !isset($info['limit']) && !isset($info['page'])) {
        return $pr;
    }
    if ($info['total_count'] == 0) {
        return $pr;
    }

    // 展開
    extract($info);
    $pr = "All <b>{$info['total_count']}</b> items&nbsp;"
        . "{$info['offset']} - {$info['limit']} <b>{$info['page']}</b> show page";

    return $pr;
}
?>