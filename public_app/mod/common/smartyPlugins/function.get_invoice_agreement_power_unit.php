<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.get_invoice_agreement_power_unit.php
 * Type:     function
 * Name:     get_invoice_agreement_power_unit
 * Purpose:  請求書画面の
 *
 *  @param  string  $unit    契約電力単位
 * -------------------------------------------------------------
 */
function smarty_function_get_invoice_agreement_power_unit($params, &$smarty)
{
    extract($params);
    $ret = "";
    switch($unit) {
      case AGREEMENT_CAPACITY_UNIT_kVA: // kVA
          $ret = "kVA/kWh";
          break;
      case AGREEMENT_CAPACITY_UNIT_A:  // A
      case AGREEMENT_CAPACITY_UNIT_kW: // kW
      case AGREEMENT_CAPACITY_UNIT_V:  // V
          $ret = "kW/kWh";
          break;
      default :
          break;
    }
    return $ret;
}
?>