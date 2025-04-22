SELECT
    count(user.f_user_id) as count
FROM
    m_user user
WHERE
    user.f_login_id = '{$param.f_tar|addslashes}'
AND
    user.f_del_flg = '{$param.f_del_flg|addslashes}'
{if !is_empty($param.f_id)}
AND
    user.f_user_id <> '{$param.f_id|addslashes}'
{/if}
