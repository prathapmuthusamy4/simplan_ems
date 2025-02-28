<?php /* Smarty version 2.6.17, created on 
         compiled from m_addemployee/select_one.sql */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'addslashes', 'm_addemployee/select_one.sql', 62, false),)), $this); ?>
SELECT
    addemployee.f_employee_id
    ,addemployee.f_emp_id
    ,addemployee.f_name
    ,addemployee.f_aadhar_number
    ,addemployee.f_pan_number
    ,addemployee.f_passport
    ,date_format(addemployee.f_issue_date, '%Y/%m/%d') as f_issue_date
    ,date_format(addemployee.f_expiry_date, '%Y/%m/%d') as f_expiry_date
    ,addemployee.f_gender
    ,date_format(addemployee.f_date_of_birth, '%Y/%m/%d') as f_date_of_birth
    ,addemployee.f_age
    ,addemployee.f_blood_group
    ,addemployee.f_status
    ,addemployee.f_address1
    ,addemployee.f_address2
    ,addemployee.f_city
    ,addemployee.f_state
    ,addemployee.f_pincode
    ,addemployee.f_country
    ,addemployee.f_mobile_number
    ,addemployee.f_office_telephone_number
    ,addemployee.f_office_email
    ,addemployee.f_personal_mail
    ,addemployee.f_relation_name
    ,addemployee.f_relationship
    ,addemployee.f_occupation
    ,addemployee.f_address
    ,addemployee.f_phone_number
    ,addemployee.f_emp_status
    ,addemployee.f_category
    ,addemployee.f_job_title
    ,addemployee.f_join_date
    ,addemployee.f_relive_date
    ,addemployee.f_location
    ,addemployee.f_experience
    ,addemployee.f_education_ug
    ,addemployee.f_degree_ug
    ,addemployee.f_university_ug
    ,addemployee.f_education_pg
    ,addemployee.f_degree_pg
    ,addemployee.f_university_pg
    ,addemployee.f_additional_skill
    ,addemployee.f_language
    ,addemployee.f_others
    ,addemployee.f_jlpt
    ,addemployee.f_bank_name
    ,addemployee.f_bank_branch
    ,addemployee.f_acc_no
    ,addemployee.f_ifsc_code
    ,addemployee.f_description
    ,addemployee.f_image
    ,addemployee.f_del_flg
    ,addemployee.f_reg_account
    ,addemployee.f_reg_time
    ,addemployee.f_upd_account
    ,addemployee.f_upd_time

FROM
    m_addemployee addemployee
WHERE
    addemployee.f_del_flg = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_del_flg'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
<?php if (isset ( $this->_tpl_vars['param']['where']['f_employee_id'] ) && ! is_empty ( $this->_tpl_vars['param']['where']['f_employee_id'] )): ?>
AND
    addemployee.f_employee_id = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_employee_id'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['param']['where']['f_emp_id'] ) && ! is_empty ( $this->_tpl_vars['param']['where']['f_emp_id'] )): ?>
AND
    addemployee.f_emp_id = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_emp_id'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
<?php endif; ?>