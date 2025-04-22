SELECT
    count(image_one.f_image_one_id) as count
FROM
    t_image_one image_one
WHERE
    image_one.f_del_flg = '{$param.where.f_del_flg|addslashes}'