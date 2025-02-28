SELECT
     customer.f_customer_id
    ,customer.f_name
    ,customer.f_dob
    ,customer.f_gender
    ,customer.f_age
    ,customer.f_blood_group
    ,customer.f_hobbies
    ,customer.f_remarks
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
ORDER BY
     customer.f_customer_id ASC
{if isset($param.limit.offset) && isset($param.limit.limit)}
LIMIT
    {sql_offset_limit offset=$param.limit.offset limit=$param.limit.limit|addslashes}
{/if}