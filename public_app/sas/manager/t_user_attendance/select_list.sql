SELECT
     attendance.f_attendance_id
    ,attendance.f_name
    ,attendance.f_leave_type
    ,attendance.f_leave_reason
    ,date_format(attendance.f_date, '%Y/%m/%d') as f_date
FROM
    t_user_attendance attendance
WHERE
    attendance.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset("f_name", $param.where)}
AND
    {sql_where_like field="attendance.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_start_date", $param.where)}
AND
    date_format(attendance.f_date, '%Y/%m/%d') >= '{$param.where.f_start_date|addslashes}'
{/if}
{if is_isset("f_end_date", $param.where)}
AND
    date_format(attendance.f_date, '%Y/%m/%d') <= '{$param.where.f_end_date|addslashes}'
{/if}
{if is_isset("f_status", $param.where)}
AND
    attendance.f_status = "{$param.where.f_status|addslashes}"
{/if}
ORDER BY
    attendance.f_attendance_id DESC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}
