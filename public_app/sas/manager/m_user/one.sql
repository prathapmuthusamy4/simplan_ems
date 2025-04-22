SELECT
     user.f_user_id
    ,user.f_name
    ,user.f_firstname
    ,user.f_mailaddress
    ,user.f_mailaddress as mail
FROM
    m_user user
WHERE
    user.f_del_flg = '{$param.f_del_flg|addslashes}'
{if is_isset('f_mailaddress', $param)}
AND
    user.f_mailaddress = '{$param.f_mailaddress|addslashes}'
{/if}
{* {if is_isset('f_admin_kbn', $param)}
AND
    user.f_admin_kbn = '{$param.f_admin_kbn|addslashes}'
{/if } *}
