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
function smarty_function_admin_page_feed($params, &$smarty)
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

    //*** 不正引数のチェック ***//
    if (!preg_match("/^\d+$/", $info['total_count']) || $info['total_count'] < 1) {
        $pr = "";
    } else {
        $pr = "[ {$info['total_count']} 件中 {$info['offset']} 〜 {$info['limit']} 件 {$info['page']} ページ目を表示 ]";
    }

    //*** 処理を実行させるURLを決定 ***//
    if (!isset($url) || $url == '') {
        // 未入力時は現在と同じindexファイルを使用 //
        $url_string = $_SERVER['PHP_SELF'];
    } else {
        $url_string = $url;
    }

    // 文字列生成の開始 //
    $pr = "";

    if ($info['page'] > 1) {
        // 最初のページではない場合 //
        $pr .= "<< <a href=\"javascript:pagefrm('{$url_string}', '{$process}', 'change_page', 1)\">";
        $pr .= "First{$info['page_limit']}</a>";
        $prevPage = $info['page'] - 1;
        $pr .= " < <a href=\"javascript:pagefrm('{$url_string}', '{$process}', 'change_page', {$prevPage})\">";
        $pr .= "Previous{$info['page_limit']}</a>";
    } else {
        // 最初のページの場合 //
        $pr .= "<font color=\"gray\"><< First {$info['page_limit']} < Previous {$info['page_limit']} </font>";
    }

    $pr .= " | ";

    if ($info['page'] < $info['max_page']) {
        // 最後ページではない場合
        $nextPage = $info['page'] + 1;
        $pr .= "<a href=\"javascript:pagefrm('{$url_string}', '{$process}', 'change_page', {$nextPage})\">";
        $pr .= "Next{$info['page_limit']}</a>";
        $pr .= " > <a href=\"javascript:pagefrm('{$url_string}', '{$process}', 'change_page', {$info['max_page']})\">";
        $pr .= "Last{$info['page_limit']} >></a>";
    } else {
        // 最後のページの場合
        $pr .= "<font color=\"gray\">Next {$info['page_limit']} > Last {$info['page_limit']} >></font>";
    }

    //*** 戻り値を設定 ***//
    return $pr;
}
?>