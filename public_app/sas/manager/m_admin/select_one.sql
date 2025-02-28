SELECT
     ma.f_admin_id
    ,ma.f_name
    ,ma.f_mailaddress
    ,ma.f_id
    ,ma.f_admin_kbn
    ,ma.f_auth
    ,ma.f_auth_value
    ,ma.f_del_flg
    ,ma.f_reg_account
    ,ma.f_reg_time
    ,ma.f_upd_account
    ,ma.f_upd_time
FROM
    m_admin ma
WHERE
    ma.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_admin_id) && !is_empty($param.where.f_admin_id)}
AND
    ma.f_admin_id = {$param.where.f_admin_id|addslashes}
{/if}