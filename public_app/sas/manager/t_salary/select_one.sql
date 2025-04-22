SELECT
    salary.f_employee_id
    ,salary.f_salary_id
    ,salary.f_salary_month
    ,salary.f_no_of_working_days
    ,salary.f_no_of_present_days
    ,salary.f_basic_salary
    ,salary.f_hra
    ,salary.f_medical
    ,salary.f_conveyance
    ,salary.f_other_earnings
    ,salary.f_total_earnings
    ,salary.f_pf
    ,salary.f_tax
    ,salary.f_other_deduction
    ,salary.f_total_deduction
    ,salary.f_del_flg
    ,salary.f_reg_account
    ,salary.f_reg_time
    ,salary.f_upd_account
    ,salary.f_upd_time

FROM
    t_salary salary
WHERE
    salary.f_del_flg = '{$param.where.f_del_flg|addslashes}'
{if isset($param.where.f_employee_id) && !is_empty($param.where.f_employee_id)}
AND
    salary.f_employee_id = '{$param.where.f_employee_id|addslashes}'
{/if}
{if isset($param.where.f_salary_month) && !is_empty($param.where.f_salary_month)}
AND
    salary.f_salary_month = '{$param.where.f_salary_month|addslashes}'
{/if}
