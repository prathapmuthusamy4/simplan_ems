SELECT
     priya.f_priya_id
    ,priya.f_name
    ,date_format(priya.f_dob, '%Y/%m/%d') as f_dob
    ,priya.f_gender
    ,priya.f_graduate
    ,priya.f_mark
    ,priya.f_hobbies
    ,priya.f_age
    ,priya.f_blood_group
    ,priya.f_divya_id
    ,priya.f_remarks
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
ORDER BY
     priya.f_priya_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}