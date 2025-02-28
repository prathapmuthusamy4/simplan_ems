SELECT
    count(normal.f_normal_id) as count
FROM
    t_normal normal
WHERE
    normal.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_name', $param.where)}
AND
    {sql_where_like field="normal.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_blood_group", $param.where)}
AND
    normal.f_blood_group = '{$param.where.f_blood_group|addslashes}'
{/if}
