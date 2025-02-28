SELECT
     user.f_user_id
    ,user.f_name
    ,user.f_surname_kana
    ,user.f_mailaddress
    ,user.f_login_id
    ,user.f_del_flg
    ,user.f_reg_account
    ,user.f_reg_time
    ,user.f_upd_account
    ,user.f_upd_time
FROM
    m_user user
WHERE
    user.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_user_id) && !is_empty($param.where.f_user_id)}
AND
    user.f_user_id = '{$param.where.f_user_id|addslashes}'
{/if}
