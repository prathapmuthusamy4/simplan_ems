<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sql_where_in
 * Type:     function
 * Name:     sql_where_in
 * Purpose:  IN WHERE句を生成する
 *
 *  @param  array   $params    入力値
 *  @return string  where in句
 * -------------------------------------------------------------
 */
function smarty_function_sql_where_in($params, &$smarty)
{
    extract($params);

    return SimplanDBUtil::makeWhereIn($field, $target);
}
?>