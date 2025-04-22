SELECT
     divya.f_divya_id
    ,divya.f_reg_no
    ,divya.f_name
    ,date_format(divya.f_dob, '%Y/%m/%d') as f_dob
    ,divya.f_gender
    ,divya.f_graduate
    ,divya.f_mark
    ,divya.f_age
    ,divya.f_blood_group
    ,divya.f_hobbies
    ,divya.f_priya_id
    ,divya.f_remarks
  
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
ORDER BY
     divya.f_divya_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}