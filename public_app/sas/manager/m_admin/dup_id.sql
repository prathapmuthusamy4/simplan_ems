SELECT
    count(ma.f_admin_id) as count
FROM
    m_admin ma
WHERE
    ma.f_id = '{$param.f_tar|addslashes}'
AND
    ma.f_del_flg = '{$param.f_del_flg|addslashes}'
{if !is_empty($param.f_id)}
AND
    ma.f_admin_id <> {$param.f_id|addslashes}
{/if}