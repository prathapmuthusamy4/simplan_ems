SELECT
     image_one.f_image_one_id
    ,image_one.f_image
    ,image_one.f_del_flg
    ,image_one.f_reg_account
    ,image_one.f_reg_time
    ,image_one.f_upd_account
    ,image_one.f_upd_time
FROM
    t_image_one image_one
WHERE
    image_one.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_image_one_id) && !is_empty($param.where.f_image_one_id)}
AND
    image_one.f_image_one_id = {$param.where.f_image_one_id|addslashes}
{/if}