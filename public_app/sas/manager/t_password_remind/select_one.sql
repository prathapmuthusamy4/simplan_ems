SELECT
     password_remind.f_remind_id
    ,password_remind.f_user_id
    ,password_remind.f_valid_date
FROM
    t_password_remind password_remind
WHERE
    password_remind.f_valid_date >= now()
{if is_isset('f_key', $param.where)}
AND
    password_remind.f_ref_key = '{$param.where.f_key|addslashes}'
{/if}