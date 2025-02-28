<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sql_where_regexp
 * Type:     function
 * Name:     sql_where_regexp
 * Purpose:  正規表現 WHERE句を生成する
 *
 *  @param  array   $params    入力値
 *  @return string  where regexp
 * -------------------------------------------------------------
 */
function smarty_function_sql_where_regexp($params, &$smarty)
{
    extract($params);

    return SimplanDBUtil::makeWhereRegexp($field, $target);
}
?>