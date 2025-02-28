SELECT
     image_mul.f_image_mul_id
    ,image_mul.f_image1
    ,image_mul.f_image2
    ,image_mul.f_image3
FROM
    t_image_mul image_mul
WHERE
    image_mul.f_del_flg = '{$param.where.f_del_flg|addslashes}'
ORDER BY
    image_mul.f_image_mul_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}