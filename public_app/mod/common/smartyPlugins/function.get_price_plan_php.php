<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.get_price_plan_php.php
 * Type:     function
 * Name:     get_price_plan_php
 * Purpose:  曜日IDから曜日の日本語名を返す。
 *
 *  @param  string  $week   曜日ID
 * -------------------------------------------------------------
 */
function smarty_function_get_price_plan_php($params, &$smarty)
{
    extract($params);
    $ret = "";
    switch($menu_kbn) {
      case PRICE_MENU_TYPE_JURYO: // 従量型
          $ret = "juryo_plan.php";
          break;
      case PRICE_MENU_TYPE_TEIGAKU: // 定額型
          $ret = "teigaku_plan.php";
          break;
      case PRICE_MENU_TYPE_SEASON: // 季節型
          $ret = "season_plan.php";
          break;
      case PRICE_MENU_TYPE_JIKAHO: // 自家補
          $ret = "jikaho_plan.php";
          break;
      case PRICE_MENU_TYPE_FREE: // 自由型
          $ret = "free_plan.php";
          break;
      default :
          break;
    }
    return $ret;
}
?>