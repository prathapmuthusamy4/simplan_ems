SELECT
     priya.f_priya_id
    ,priya.f_name
    ,date_format(priya.f_dob, '%Y/%m/%d') as f_dob
    ,priya.f_age
    ,priya.f_gender
    ,priya.f_graduate
    ,priya.f_mark
    ,priya.f_blood_group
    ,priya.f_divya_id
    ,priya.f_hobbies
    ,priya.f_remarks
    ,priya.f_image1
    ,priya.f_image2
    ,priya.f_image3
    ,priya.f_del_flg
    ,priya.f_reg_account
    ,priya.f_reg_time
    ,priya.f_upd_account
    ,priya.f_upd_time
FROM
    t_priya priya
WHERE
    priya.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_priya_id) && !is_empty($param.where.f_priya_id)}
AND
    priya.f_priya_id = {$param.where.f_priya_id|addslashes}
{/if}