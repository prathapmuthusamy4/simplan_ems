SELECT
     normal.f_normal_id as id
    ,normal.f_name as name
FROM
    t_normal normal
WHERE
    normal.f_del_flg = '{$param.f_del_flg|addslashes}'