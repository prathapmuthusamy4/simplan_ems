SELECT
     td.f_divya_id as id
    ,td.f_name as name
FROM
     t_divya td
WHERE
    td.f_del_flg = '{$param.f_del_flg|addslashes}'