<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.user_page_info.php
 * Type:     function
 * Name:     user_page_info
 * Purpose:  ユーザ用画面の件数タグを出力する
 *
 *  @param  string  $total   トータル数
 *  @param  string  $current 現在のページ番号
 *  @param  string  $max     1ページあたりの最大値
 * -------------------------------------------------------------
 */
function smarty_function_user_page_navi($params, &$smarty)
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
    $pr = "{$info['max_page']}ページ中{$info['page']}ページ （計{$info['total_count']}点）";
    return $pr;
}
?>