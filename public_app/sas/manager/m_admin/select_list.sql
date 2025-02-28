SELECT
     ma.f_admin_id
    ,ma.f_name
    ,ma.f_name
    ,ma.f_admin_kbn
    ,ma.f_mailaddress
    ,ma.f_id
    ,ma.f_password
    ,ma.f_admin_kbn
    ,ma.f_auth
    ,ma.f_auth_value
FROM
    m_admin ma
WHERE
    ma.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field="ma.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_admin_kbn", $param.where)}
AND
    ma.f_admin_kbn = '{$param.where.f_admin_kbn|addslashes}'
{/if}
{if is_isset("f_admin_kbn_in", $param.where)}
AND
    ma.f_admin_kbn IN ({foreach from=$param.where.f_admin_kbn_in item="cur" name="current"}'{$cur|addslashes}'{if !$smarty.foreach.current.last},{/if}{/foreach})
{/if}
ORDER BY
    ma.f_admin_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}