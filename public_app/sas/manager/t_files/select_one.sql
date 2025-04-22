SELECT
     files.f_files_id
    ,files.f_title
    ,files.f_name
    ,files.f_mail
    ,files.f_filename
    ,files.f_file
    ,files.f_del_flg
    ,files.f_reg_account
    ,files.f_reg_time
    ,files.f_upd_account
    ,files.f_upd_time
FROM
    t_files files
WHERE
    files.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_files_id) && !is_empty($param.where.f_files_id)}
AND
    files.f_files_id = {$param.where.f_files_id|addslashes}
{/if}