SELECT
     user.f_user_id
    ,user.f_name
    ,user.f_surname_kana
    ,user.f_mailaddress
    ,user.f_login_id
    ,user.f_password
    ,user.f_del_flg
    ,user.f_reg_account
    ,user.f_reg_time
    ,user.f_upd_account
    ,user.f_upd_time
FROM
    m_user user
WHERE
    user.f_login_id = '{$param.f_login_id|addslashes}'
AND
    user.f_password = '{$param.f_password|addslashes}'
AND
    user.f_del_flg = '{$param.f_del_flg|addslashes}'
