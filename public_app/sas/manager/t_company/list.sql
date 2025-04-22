SELECT
     tc.f_company_id as id
    ,tc.f_name as name
FROM
    t_company tc
WHERE
    tc.f_del_flg = '{$smarty.const.DEL_FLG_LIST_OFF|addslashes}'
