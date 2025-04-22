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
function smarty_function_image_optimized($img, &$smarty)
{
        extract($img);

        $optimeized_info = SimplanUtil::optimizedImageInfo($image, $width, $height, $mode);

        $size = "";
        switch($target) {
        case 'w':
            $size = $optimeized_info[0];
            break;
        case 'h':
            $size = $optimeized_info[1];
            break;
        default:
            $size = "";
        }

        return $size;
}
?>