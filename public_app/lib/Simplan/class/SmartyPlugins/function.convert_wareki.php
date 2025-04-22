<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.convert_wareki.php
 * Type:     function
 * Name:     convert_wareki
 * Purpose:  西暦から和暦に変換
 *
 *  @param  string  $date   日付
 * -------------------------------------------------------------
 */
function smarty_function_convert_wareki($params, &$smarty)
{
    extract($params);

    return t_wareki($y, $m, $d);
}
?>