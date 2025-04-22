SELECT
     attendance.f_attendance_id
    ,attendance.f_name
    ,attendance.f_leave_type
    ,attendance.f_leave_reason
    ,date_format(attendance.f_date, '%Y/%m/%d') as f_date
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
ORDER BY
    attendance.f_attendance_id DESC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}