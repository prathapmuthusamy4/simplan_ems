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
function smarty_function_imageLink($img, &$smarty)
{
        extract($img);
        $pr = "";
        // チェック
        if(!file_exists($image)) {
            if (isset($default)) {
                $image = $default;
            } else {
                return $pr;
            }
        }

        $alt = isset($alt) ? $alt : "";
        $opt = isset($opt) ? $opt : "";

        if (file_exists($image)) {
            $tmp = getimagesize($image);
            // サイズが取れた場合
            if ($tmp) {

                // 幅のみ指定時
                if (isset($width) && !isset($height)) {
                    if ($width > $tmp[0]) {
                        $width = $tmp[0];
                    }
                    return "<img src=\"{$image}\" alt=\"{$alt}\" width='{$width}' {$opt}>";
                }

                // 高さのみ指定時
                if (!isset($width) && isset($height)) {
                    if ($height > $tmp[1]) {
                        $height = $tmp[1];
                    }
                    return "<img src=\"{$image}\" alt=\"{$alt}\" height='{$height}' {$opt}>";
                }

                // 幅・縦指定時
                if (isset($width) && isset($height)) {

                    $i_info = Simplanutil::optimizedImageInfo($image, $width, $height, "AUTO");

                    return "<img src=\"{$image}\" alt=\"{$alt}\" width='{$i_info[0]}' height='{$i_info[1]}' {$opt}>";
                }

            }
        }

        return $pr;
}
?>