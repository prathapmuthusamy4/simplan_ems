SELECT
    count(ma.f_admin_id) as count
FROM
    m_admin ma
WHERE
    ma.f_mailaddress = '{$param.f_mailaddress|addslashes}'
AND
    ma.f_del_flg = '{$param.f_del_flg|addslashes}'
{if !is_empty($param.f_admin_id)}
AND
    ma.f_admin_id <> '{$param.f_admin_id|addslashes}'
{/if}
