SELECT
    count(attendance.f_emp_id) as count
FROM
    t_user_attendance attendance
WHERE
    attendance.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_emp_id", $param.where)}
AND
    attendance.f_emp_id = '{$param.where.f_emp_id|addslashes}'
{/if}
{if is_isset("f_date", $param.where)}
AND
    attendance.f_date = '{$param.where.f_date|addslashes}'
{/if}
