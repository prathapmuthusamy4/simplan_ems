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
function smarty_function_user_info_page_feed($params, &$smarty)
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
    $feed = "";
    $feed_prev = "";
    $feed_last = "";
    $feed_etc  = "";
    if ($info['max_page'] == 1) {
        $feed = "";
        $feed_prev = "";
        $feed_last = "";
        $feed_etc  = "";
    } else {
        if ($info['page'] > 1) {
            // 最初のページではない場合 //
            $prevPage = $info['page'] - 1;
            $feed_prev .= "<li><a href=\"{$url_string}?prc={$process}&cmd=change_page&pno={$prevPage}\">&lt;&lt;</a></li>";
            //$feed_prev .= "<li><a href=\"javascript:pagefrm('{$url_string}', '{$process}', 'change_page', {$prevPage})\">&lt;&lt;</a></li>";
        } else {
            // 最初のページの場合 //
            $feed_prev .= "<li><a href=\"#\">&lt;&lt;</a></li>";
        }

        if ($info['page'] < $info['max_page']) {
            // 最後ページではない場合
            $lastPage = $info['max_page'];
            $feed_last .= "<li><a href=\"{$url_string}?prc={$process}&cmd=change_page&pno={$lastPage}\">&gt;&gt;</a></li>";
            //$feed_last .= "<li><a href=\"javascript:pagefrm('{$url_string}', '{$process}', 'change_page', {$lastPage})\">&gt;&gt;</a></li>";
        } else {
            // 最後のページの場合
            $feed_last .= "<li><a href=\"#\">&gt;&gt;</a></li>";
        }
    }

    //*** ダイレクトページリンク生成 ***//
    //*** ダイレクトページ数の指定が0または最大表示ページ数が1の場合 ***//
    if ($info['direct_link_limit'] == 0 || $info['max_page'] == 1) {
        //*** ダイレクトページリンク表示無し ***//
        $start = 0;
        $end = 0;

    //*** ダイレクトページリンク表示件数が最大ページ数を超えている場合 ***//
    } else if ($info['max_page'] < $info['direct_link_limit']) {
        //*** ダイレクトページリンク全表示 ***//
        $start = 1;
        $end = $info['max_page'];

    //*** 上記以外の場合 ***//
    } else {
        //*** 現在ページ前後のダイレクトページリンク表示件数取得 ***//
        $splitNum = floor(($info['direct_link_limit'] - 1) / 2);
        $start = $info['page'] - $splitNum;
        $end = $info['page'] + $splitNum;
        //*** 開始番号が1より小さい場合 ***//
        if ($start < 1) {
            //*** 開始番号は1に設定 ***//
            $start = 1;
            //*** 終了番号は開始番号のハミ出た分だけ後ろにずらす ***//
            $end = $end + ($splitNum - ($info['page'] - 1));
        }
        //*** 開始番号が最大ページ数より大きい場合 ***//
        if ($end > $info['max_page']) {
            //*** 開始番号は終了番号のハミ出た分だけ前にずらす ***//
            $start = $start - ($splitNum - ($info['max_page'] - $info['page']));
            //*** 終了番号は最大ページ数に設定 ***//
            $end = $info['max_page'];
        }
    }

    $pre  = "";
    $last = "";
    $feedNum = array();
    //*** 開始番号と終了番号が共に0以外の場合 ***//
    if ($start != 0 && $end != 0) {
        $pre = "<ul class=\"pagenavi\">";
        $last = "</ul>";
        for ($idx = $start; $idx <= $end; $idx++) {
            if ($idx == $info['page']) {
                //*** 現在のページの場合 ***//
                $feedNum[] = "<li><span>{$idx}</span></li>";
            } else {
                //*** 現在のページでない場合 ***//
                $feedNum[] = "<li><a href=\"{$url_string}?prc={$process}&cmd=change_page&pno={$idx}\">{$idx}</a></li>";
//                $feedNum[] = "<li><a href=\"JavaScript:pagefrm('{$url_string}', '{$process}', 'change_page', {$idx})\">{$idx}</a></li>";
            }
        }
    }
    //*** 配列に格納したダイレクトページリンクを空白で結合 ***//
    $feedNum = implode('', $feedNum);

    $returnItem = $pre . $feed_prev . $feedNum . $feed_last . $last;

    //*** 戻り値を設定 ***//
    return $returnItem;
}
?>