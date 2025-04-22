SELECT
     history.f_history_id
    ,history.f_user_id
    ,date_format(history.f_datetime, '%Y/%m/%d %H:%i:%s') as f_datetime
    ,user.f_surname as f_name
FROM
    t_history history
LEFT JOIN
    m_user user
ON
    history.f_user_id = user.f_user_id
WHERE
    history.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_name', $param.where)}
AND
    {sql_where_like field="user.f_surname" target=$param.where.f_name|addslashes}
{/if}
{if is_isset('searchFromDate', $param.where)}
AND
    DATE_FORMAT(history.f_datetime, '%Y%m%d') >= DATE_FORMAT('{$param.where.searchFromDate|addslashes}', '%Y%m%d')
{/if}
{if is_isset('searchToDate', $param.where)}
AND
    DATE_FORMAT(history.f_datetime, '%Y%m%d') <= DATE_FORMAT('{$param.where.searchToDate|addslashes}', '%Y%m%d')
{/if}
