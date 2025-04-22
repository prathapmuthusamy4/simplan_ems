SELECT
    count(customer.f_customer_id) as count
FROM
    t_customer customer
WHERE
    customer.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if is_isset('f_name', $param.where)}
AND
    {sql_where_like field="customer.f_name" target=$param.where.f_name|addslashes}
{/if}
{if is_isset("f_blood_group", $param.where)}
AND
    customer.f_blood_group = '{$param.where.f_blood_group|addslashes}'
{/if}
