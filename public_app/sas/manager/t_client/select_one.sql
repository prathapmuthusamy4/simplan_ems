SELECT
     tc.f_client_id
    ,tc.f_name
    ,tc.f_device
    ,tc.f_device_size
    ,tc.f_device_color
    ,tc.f_device_price
    ,tc.f_del_flg
    ,tc.f_reg_account
    ,tc.f_reg_time
    ,tc.f_upd_account
    ,tc.f_upd_time
FROM
    t_client tc
WHERE
    tc.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_client_id) && !is_empty($param.where.f_client_id)}
AND
    tc.f_client_id = {$param.where.f_client_id|addslashes}
{/if}