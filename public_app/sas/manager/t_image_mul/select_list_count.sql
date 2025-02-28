SELECT
    count(image_mul.f_image_mul_id) as count
FROM
    t_image_mul image_mul
WHERE
    image_mul.f_del_flg = '{$param.where.f_del_flg|addslashes}'