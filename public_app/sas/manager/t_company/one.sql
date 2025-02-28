SELECT
    tc.f_company_id
FROM
    t_company tc
WHERE
    tc.f_del_flg = '{$param.f_del_flg|addslashes}'
{if is_isset('f_device', $param)}
AND
    tc.f_name = '{$param.f_device|addslashes}'
{/if}