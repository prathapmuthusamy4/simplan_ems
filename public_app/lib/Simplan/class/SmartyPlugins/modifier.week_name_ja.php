<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.week_name_ja.php
 * Type:     modifier
 * Name:     week_name
 * Purpose:  日本語曜日名
 *
 *  @param  string   $year     年
 *  @param  string   $month    月
 *  @param  string   $day      日
 * -------------------------------------------------------------
 */
function smarty_modifier_week_name_ja($year, $month, $day)
{
    if (is_empty($year) || is_empty($month) || is_empty($day)) {
        return "";
    }

    $w = date("w", mktime(0, 0, 0, $month, $day, $year));
    $ret = "";
    switch($w) {
      case 0: // 日曜日
          $ret = "日";
          break;
      case 1: // 月曜日
          $ret = "月";
          break;
      case 2: // 火曜日
          $ret = "火";
          break;
      case 3: // 水曜日
          $ret = "水";
          break;
      case 4: // 木曜日
          $ret = "木";
          break;
      case 5: // 金曜日
          $ret = "金";
          break;
      case 6: // 土曜日
          $ret = "土";
          break;
    }

    return $ret;

}
?>