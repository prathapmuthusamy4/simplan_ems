SELECT
    count(tc.f_client_id) as count
FROM
    t_client tc
WHERE
    tc.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field=tc.f_name target=$param.where.f_name|addslashes}
{/if}

