SELECT
     sample.f_id
    ,sample.f_name
    ,sample.f_address
    ,sample.f_mailaddress
    ,sample.f_time
FROM
    t_sample sample
WHERE
     sample.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('now_date', $param.where)}
AND
    DATE_FORMAT(sample.f_time, '%Y%m%d%H%i') = '{$param.where.now_date|addslashes}'
{/if}