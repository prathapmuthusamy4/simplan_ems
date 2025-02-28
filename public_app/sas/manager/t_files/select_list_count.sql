SELECT
    count(files.f_files_id) as count
FROM
    t_files files
WHERE
    files.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_title', $param.where)}
AND
    {sql_where_like field="files.f_title" target=$param.where.f_title|addslashes}
{/if}
