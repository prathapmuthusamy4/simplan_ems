SELECT
     normal.f_normal_id
    ,normal.f_name
    ,date_format(normal.f_dob, '%Y/%m/%d') as f_dob
    ,normal.f_age
    ,normal.f_gender
    ,normal.f_blood_group
    ,normal.f_hobbies
    ,normal.f_remarks
FROM
    t_normal normal
WHERE
    normal.f_del_flg = '{$param.f_del_flg|addslashes}'
{if isset($param.where.f_normal_id) && !is_empty($param.where.f_normal_id)}
AND
    normal.f_normal_id = {$param.where.f_normal_id|addslashes}
{/if}