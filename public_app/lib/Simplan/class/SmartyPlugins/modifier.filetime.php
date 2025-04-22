<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.filetime.php
 * Type:     modifier
 * Name:     filetime
 * Purpose:  ファイルの時刻を取得する
 *
 *
 *  sample:
 *  <code>
 *  {"index.html"|filetime:"Y/M/d"}
 *  </code>
 *  <code>
 *   2008/04/22
 *  </code>
 *
 *  @param  string  $string  対象ファイル
 *  @param  string  $format  フォーマット
 * -------------------------------------------------------------
 */
function smarty_modifier_filetime($string, $format) {

    $ret = "";
    if(file_exists($string)){
        $time = date($format, filemtime($string));
        $ret = $time;
    }

    return $ret;
}
?>