SELECT
     user.f_user_id
    ,user.f_name
    ,user.f_firstname
    ,user.f_surname_kana
    ,user.f_firstname_kana
    ,user.f_mailaddress
    ,user.f_login_id
    ,user.f_password
FROM
    m_user user
WHERE
    user.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field="concat(ifnull(ma.f_name, ''), ifnull(ma.f_firstname, ''))" target=$param.where.f_name|addslashes}
{/if}
ORDER BY
    user.f_user_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}
