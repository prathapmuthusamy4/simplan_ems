<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.display_duration_from_to.php
 * Type:     function
 * Name:     display_duration_from_to
 * Purpose:  料金アイテム期間の FROM TO を表示
 *
 *  @param  string  $value   表示フラグ
 * -------------------------------------------------------------
 */
function smarty_function_display_duration_from_to($params, &$smarty)
{
    $ret = "";
    extract($params);

    if (isset($duration) && !is_empty($duration)) {
        $array = explode(',', $duration);
        $fr = '';
        $to = '';
        foreach ((array)$array as $value) {
            if (is_empty($fr)) {
                $fr = $value;
            }
            $to = $value;
        }
        $fr_m = '';
        $fr_d = '';
        $to_m = '';
        $to_d = '';
        if (preg_match("/^(\d{2})(\d{2})$/", $fr, $fr_md)) {
            $fr_m = $fr_md[1];
            $fr_d = $fr_md[2];
        }
        if (preg_match("/^(\d{2})(\d{2})$/", $to, $to_md)) {
            $to_m = $to_md[1];
            $to_d = $to_md[2];
        }
        $ret = "{$fr_m}/{$fr_d} ～ {$to_m}/{$to_d}";
    }
    return $ret;
}
?>