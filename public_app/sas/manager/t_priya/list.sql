SELECT
     td.f_priya_id as id
    ,td.f_name as name
FROM
     t_priya td
WHERE
    td.f_del_flg = '{$param.f_del_flg|addslashes}'