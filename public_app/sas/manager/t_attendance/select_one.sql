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
{if isset($param.where.f_attendance_id) && !is_empty($param.where.f_attendance_id)}
AND
    attendance.f_attendance_id = {$param.where.f_attendance_id|addslashes}
{/if}