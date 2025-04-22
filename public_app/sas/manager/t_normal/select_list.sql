SELECT
     normal.f_normal_id
    ,normal.f_name
    ,normal.f_gender
    ,normal.f_age
    ,normal.f_blood_group
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
ORDER BY
     normal.f_normal_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}