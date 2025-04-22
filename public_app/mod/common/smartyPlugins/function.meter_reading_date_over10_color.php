<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.meter_reading_date_over10_color.php
 * Type:     function
 * Name:     meter_reading_date_over10_color
 * Purpose:  現在日が検針日の10日移行の場合赤色を返す。
 *
 *  @param  string  $color
 * -------------------------------------------------------------
 */
function smarty_function_meter_reading_date_over10_color($params, &$smarty)
{
    extract($params);

    $color = "#FFFFFF";
    $dateTime         = new DateTime($meter_reading_date);
    $meterReadingDate = $dateTime->modify("+10 days")->format("Ymd");
    // 現在日が検針日の10日以降の場合
    if ($meterReadingDate < date("Ymd")) {
        $color = "#fff0f5";
    }
    return $color;
}
?>