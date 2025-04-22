SELECT
    count(divya.f_reg_no) as f_reg_no
FROM
    t_divya divya
WHERE
    divya.f_del_flg = {$param.f_del_flg|addslashes}
{if is_isset("f_reg_no", $param)}
AND
    divya.f_reg_no = {$param.f_reg_no|addslashes}
{/if}

