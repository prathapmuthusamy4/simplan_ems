<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sql_where_age
 * Type:     function
 * Name:     sql_where_age
 * Purpose:  年齢 WHERE句を生成する
 *
 *  @param  array   $params    入力値
 *  @return string  where      年齢
 * -------------------------------------------------------------
 */
function smarty_function_sql_where_age($params, &$smarty)
{
    extract($params);

    return "truncate(((date_format(curdate(), '%Y%m%d') - date_format({$field}, '%Y%m%d')) / 10000), 0)";
}
?>