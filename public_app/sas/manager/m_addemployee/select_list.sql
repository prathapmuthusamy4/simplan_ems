SELECT
    addemployee.f_employee_id
    ,addemployee.f_emp_id
    ,addemployee.f_name
    ,addemployee.f_aadhar_number
    ,addemployee.f_pan_number
    ,addemployee.f_passport
    ,date_format(addemployee.f_issue_date, '%Y/%m/%d') as f_issue_date
    ,date_format(addemployee.f_expiry_date, '%Y/%m/%d') as f_expiry_date
    ,date_format(addemployee.f_date_of_birth, '%Y/%m/%d') as f_date_of_birth
    ,addemployee.f_mobile_number
    ,addemployee.f_image
    ,addemployee.f_emp_status
    ,addemployee.f_passport_alert
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
ORDER BY
    addemployee.f_emp_status, addemployee.f_emp_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}
