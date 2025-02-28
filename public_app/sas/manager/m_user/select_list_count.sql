SELECT
    count(user.f_user_id) as count
FROM
    m_user user
WHERE
    user.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field="concat(ifnull(ma.f_name, ''), ifnull(ma.f_firstname, ''))" target=$param.where.f_name|addslashes}
{/if}
