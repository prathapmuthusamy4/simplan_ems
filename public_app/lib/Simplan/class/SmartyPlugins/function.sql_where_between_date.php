<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sql_where_between_date
 * Type:     function
 * Name:     sql_where_between_date
 * Purpose:  日付の期間 WHERE句を生成する
 *
 *  @param  array   $params    入力値
 *  @return string  where      日付の期間
 * -------------------------------------------------------------
 */
function smarty_function_sql_where_between_date($params, &$smarty)
{
    extract($params);

    return "date({$field}) {$code} str_to_date('{$value}', '%Y%m%d')";
}
?>