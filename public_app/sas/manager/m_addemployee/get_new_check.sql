SELECT
     addemployee.f_emp_id as f_emp_id
    ,addemployee.f_aadhar_number as f_aadhar_number
    ,addemployee.f_pan_number as f_pan_number
    ,addemployee.f_passport as f_passport
    ,addemployee.f_mobile_number as f_mobile_number
    ,addemployee.f_office_email as f_office_email

FROM
    m_addemployee addemployee
WHERE
    addemployee.f_del_flg = {$param.f_del_flg|addslashes}
ORDER BY
    addemployee.f_emp_id ASC
