SELECT
     files.f_files_id as id
    ,files.f_file as name
FROM
    t_files files
WHERE
    files.f_del_flg = '{$param.f_del_flg|addslashes}'
