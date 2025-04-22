SELECT
    count(addemployee.f_employee_id) as count
FROM
    m_addemployee addemployee
WHERE
    addemployee.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_name', $param.where)}
AND
    {sql_where_like field="addemployee.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_emp_id", $param.where)}
AND
    addemployee.f_emp_id = '{$param.where.f_emp_id|addslashes}'
{/if}
{if is_isset("f_emp_status", $param.where)}
AND
    addemployee.f_emp_status = '{$param.where.f_emp_status|addslashes}'
{/if}
{if is_isset('f_language', $param.where)}
AND (
    {foreach from=$param.where.f_language item="cur" name="current"}
        {if !$smarty.foreach.current.first}
            OR
        {/if}
        {sql_where_like field="addemployee.f_language" target=$cur|addslashes}
    {/foreach}
)
{/if}