SELECT
     image_mul.f_image_mul_id
    ,image_mul.f_image1
    ,image_mul.f_image2
    ,image_mul.f_image3
    ,image_mul.f_del_flg
    ,image_mul.f_reg_account
    ,image_mul.f_reg_time
    ,image_mul.f_upd_account
    ,image_mul.f_upd_time
FROM
    t_image_mul image_mul
WHERE
    image_mul.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_image_mul_id) && !is_empty($param.where.f_image_mul_id)}
AND
    image_mul.f_image_mul_id = {$param.where.f_image_mul_id|addslashes}
{/if}