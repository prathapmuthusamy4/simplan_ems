SELECT
     customer.f_customer_id
    ,customer.f_name
    ,date_format(customer.f_dob, '%Y/%m/%d') as f_dob
    ,customer.f_age
    ,customer.f_gender
    ,customer.f_blood_group
    ,customer.f_hobbies
    ,customer.f_remarks
FROM
    t_customer customer
WHERE
    customer.f_del_flg = '{$param.f_del_flg|addslashes}'
{if isset($param.where.f_customer_id) && !is_empty($param.where.f_customer_id)}
AND
    customer.f_customer_id = {$param.where.f_customer_id|addslashes}
{/if}