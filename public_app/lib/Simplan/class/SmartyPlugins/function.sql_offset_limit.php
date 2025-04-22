<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sql_offset_limit
 * Type:     function
 * Name:     sql_offset_limit
 * Purpose:  SQL LIMIT句
 *
 *  @param  array   $params    入力値
 *  @return String  SQL LIMIT句
 * -------------------------------------------------------------
 */
function smarty_function_sql_offset_limit($params, &$smarty)
{
    extract($params);

    return SimplanDBUtil::makeLimit($offset, $limit);
}
?>