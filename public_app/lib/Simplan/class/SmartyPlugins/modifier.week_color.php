<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.number_format.php
 * Type:     modifier
 * Name:     number_format
 * Purpose:  フォーマット済み文字列
 *
 *  @param  array   $list    リスト
 *  @param  string  $value   現在値
 * -------------------------------------------------------------
 */
function smarty_modifier_week_color($day, $year, $month)
{
    if ($day === "" || $day == null) {
        return "";
    }

    $w = date("w", mktime(0, 0, 0, $month, $day, $year));
    $ret = "";
    switch($w) {
      case 0: // 日曜日
          $ret = "<font color=\"#F8ADC4\">";
          break;
      case 6: // 土曜日
          $ret = "<font color=\"#AFBCF1\">";
          break;
      case 1: // 月曜日
      case 2: // 火曜日
      case 3: // 水曜日
      case 4: // 木曜日
      case 5: // 金曜日
          $ret = "<font color=\"black\">";
          break;
    }

    return $ret;

}
?>