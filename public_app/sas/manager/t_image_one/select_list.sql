SELECT
     image_one.f_image_one_id
    ,image_one.f_image
FROM
    t_image_one image_one
WHERE
    image_one.f_del_flg = '{$param.where.f_del_flg|addslashes}'
ORDER BY
    image_one.f_image_one_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}