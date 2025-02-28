<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.week_name_ja.php
 * Type:     function
 * Name:     week_name_ja
 * Purpose:  曜日IDから曜日の日本語名を返す。
 *
 *  @param  string  $week   曜日ID
 * -------------------------------------------------------------
 */
function smarty_function_week_name_ja($params, &$smarty)
{
    $ret = "";
    extract($params);

    $w   = $week;
    $ret = "";
    switch($w) {
      case 0: // 日曜日
          $ret = "<font color=\"#F8ADC4\">日</font>";
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
          $ret = "<font color=\"#AFBCF1\">土</font>";
          break;
      default :
          break;
    }

    return $ret;
}
?>