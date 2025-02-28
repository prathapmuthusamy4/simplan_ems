SELECT
     tc.f_company_id
    ,tc.f_name
    ,tc.f_size
    ,tc.f_color
    ,tc.f_price
FROM
    t_company tc
WHERE
    tc.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_company_id) && !is_empty($param.where.f_company_id)}
AND
    tc.f_company_id = {$param.where.f_company_id|addslashes}
{/if}