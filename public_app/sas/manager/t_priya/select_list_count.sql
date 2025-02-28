SELECT
    count(priya.f_priya_id) as count
FROM
    t_priya priya
WHERE
    priya.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_name', $param.where)}
AND
    {sql_where_like field="priya.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_blood_group", $param.where)}
AND
    priya.f_blood_group = '{$param.where.f_blood_group|addslashes}'
{/if}
