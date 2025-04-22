SELECT
     divya.f_divya_id
    ,divya.f_reg_no
    ,divya.f_name
    ,date_format(divya.f_dob, '%Y/%m/%d') as f_dob
    ,divya.f_age
    ,divya.f_gender
    ,divya.f_graduate
    ,divya.f_mark
    ,divya.f_blood_group
    ,divya.f_priya_id
    ,divya.f_hobbies
    ,divya.f_remarks
    ,divya.f_image1
    ,divya.f_image2
    ,divya.f_image3
    ,divya.f_del_flg
    ,divya.f_reg_account
    ,divya.f_reg_time
    ,divya.f_upd_account
    ,divya.f_upd_time
FROM
    t_divya divya
WHERE
    divya.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_divya_id) && !is_empty($param.where.f_divya_id)}
AND
    divya.f_divya_id = {$param.where.f_divya_id|addslashes}
{/if}