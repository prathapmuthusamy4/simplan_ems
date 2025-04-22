SELECT
     employe.f_employee_id as id
    ,employe.f_name as name
FROM
    m_employe employe
WHERE
    employe.f_del_flg = '{$param.f_del_flg|addslashes}'