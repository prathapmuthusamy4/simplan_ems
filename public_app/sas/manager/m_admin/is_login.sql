SELECT
     ma.f_admin_id
    ,ma.f_name
    ,ma.f_mailaddress
    ,ma.f_id
    ,ma.f_password
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
    ma.f_admin_id = {$param.f_admin_id|addslashes}