SELECT
     files.f_files_id
    ,files.f_name
    ,files.f_mail
    ,files.f_title
    ,files.f_filename
    ,files.f_file
FROM
    t_files files
WHERE
    files.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_title', $param.where)}
AND
    {sql_where_like field="files.f_title" target=$param.where.f_title|addslashes}
{/if}
ORDER BY
     files.f_files_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}