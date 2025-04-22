<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.convert_wareki_y.php
 * Type:     function
 * Name:     convert_wareki_y
 * Purpose:  西暦から和暦に変換
 *
 *  @param  string  $date   日付
 * -------------------------------------------------------------
 */
function smarty_function_convert_wareki_y($params, &$smarty)
{
    extract($params);

    return t_wareki_cap($y);
}
?>