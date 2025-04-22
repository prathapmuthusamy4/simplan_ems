SELECT
    count(divya.f_divya_id) as count
FROM
    t_divya divya
WHERE
    divya.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_reg_no", $param.where)}
AND
    divya.f_reg_no = '{$param.where.f_reg_no|addslashes}'
{/if}
{if is_isset('f_name', $param.where)}
AND
    {sql_where_like field="divya.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_blood_group", $param.where)}
AND
    divya.f_blood_group = '{$param.where.f_blood_group|addslashes}'
{/if}
