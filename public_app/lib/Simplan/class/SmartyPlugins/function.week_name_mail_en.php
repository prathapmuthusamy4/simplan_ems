<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.week_name_mail_en.php
 * Type:     function
 * Name:     week_name_mail_en
 * Purpose:  曜日IDから曜日の英語名を返す。
 *
 *  @param  string  $week   曜日ID
 * -------------------------------------------------------------
 */
function smarty_function_week_name_mail_en($params, &$smarty)
{
    $ret = "";
    extract($params);

    $w   = $week;
    $ret = "";
    switch($w) {
      case 0: // 日曜日
          $ret = "Sun";
          break;
      case 1: // 月曜日
          $ret = "Mon";
          break;
      case 2: // 火曜日
          $ret = "Tue";
          break;
      case 3: // 水曜日
          $ret = "Wed";
          break;
      case 4: // 木曜日
          $ret = "Thu";
          break;
      case 5: // 金曜日
          $ret = "Fri";
          break;
      case 6: // 土曜日
          $ret = "Sat";
          break;
      default :
          break;
    }

    return $ret;
}
?>