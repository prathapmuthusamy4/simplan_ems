<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sql_where_like
 * Type:     function
 * Name:     sql_where_like
 * Purpose:  LIKE WHERE句を生成する
 *
 *  @param  array   $params    入力値
 *  @return string  where like句
 * -------------------------------------------------------------
 */
function smarty_function_sql_where_like($params, &$smarty)
{
    extract($params);

    return SimplanDBUtil::makeWhereLike($field, $target);
}
?>