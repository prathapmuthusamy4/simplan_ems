SELECT
    count(password_remind.f_remind_id) as count
FROM
    t_password_remind password_remind
WHERE
    1 = 1
{if is_isset("f_ref_key", $param)}
AND
    password_remind.f_ref_key = '{$param.f_ref_key|addslashes}'
{/if}