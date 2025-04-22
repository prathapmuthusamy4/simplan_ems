SELECT
     customer.f_customer_id as id
    ,customer.f_name as name
FROM
    t_customer customer
WHERE
    customer.f_del_flg = '{$param.f_del_flg|addslashes}'