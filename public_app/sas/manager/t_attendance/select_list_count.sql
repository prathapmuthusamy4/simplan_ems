SELECT
    count(attendance.f_attendance_id) as count
FROM
    t_attendance attendance
WHERE
    attendance.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field="attendance.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_date", $param.where)}
AND
    attendance.f_date = '{$param.where.f_date|addslashes}'
{/if}

