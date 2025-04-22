SELECT
    count(divya.f_reg_no) as f_reg_no
FROM
    t_divya divya
WHERE
    divya.f_del_flg = {$param.where.f_del_flg|addslashes}
{if is_isset("f_reg_no", $param.where)}
AND
    divya.f_reg_no = {$param.where.f_reg_no|addslashes}
{/if}

