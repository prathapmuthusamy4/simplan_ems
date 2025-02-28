<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.mobile_page_info.php
 * Type:     function
 * Name:     mobile_page_info
 * Purpose:  モバイル用画面の件数タグを出力する
 *
 *  @param  string  $total   トータル数
 *  @param  string  $current 現在のページ番号
 *  @param  string  $max     1ページあたりの最大値
 * -------------------------------------------------------------
 */
function smarty_function_mobile_page_feed($params, &$smarty)
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
        $pr = "[ {$info['total_count']} 件中 {$info['offset']} ? {$info['limit']} 件 {$info['page']} ページ目を表示 ]";
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
        $prevPage = $info['page'] - 1;
        $pr .= "<a href=\"{$url_string}?prc={$process}&cmd=change_page&pno={$prevPage}\">";
        $pr .= "←前</a>";
    } else {
        // 最初のページの場合 //
        $pr .= "<font color=\"gray\">←前</font>";
    }

    $pr .= " {$info['page']}/{$info['max_page']} ";

    if ($info['page'] < $info['max_page']) {
        // 最後ページではない場合
        $nextPage = $info['page'] + 1;
        $pr .= "<a href=\"{$url_string}?prc={$process}&cmd=change_page&pno={$nextPage}\">";
        $pr .= "次→</a>";
    } else {
        // 最後のページの場合
        $pr .= "<font color=\"gray\">次→</font>";
    }

    //*** 戻り値を設定 ***//
    return $pr;
}
?>