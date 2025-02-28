SELECT
     tc.f_client_id
    ,tc.f_name
    ,tc.f_device
    ,tc.f_device_size
    ,tc.f_device_color
    ,tc.f_device_price
FROM
    t_client tc
WHERE
    tc.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field=tc.f_name target=$param.where.f_name|addslashes}
{/if}
ORDER BY
    tc.f_client_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}