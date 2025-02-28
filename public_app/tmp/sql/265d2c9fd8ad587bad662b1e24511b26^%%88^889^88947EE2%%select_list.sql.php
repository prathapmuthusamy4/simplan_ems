<?php /* Smarty version 2.6.17, created on 
         compiled from m_addemployee/select_list.sql */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'addslashes', 'm_addemployee/select_list.sql', 18, false),array('function', 'sql_where_like', 'm_addemployee/select_list.sql', 21, false),array('function', 'sql_offset_limit', 'm_addemployee/select_list.sql', 45, false),)), $this); ?>
SELECT
    addemployee.f_employee_id
    ,addemployee.f_emp_id
    ,addemployee.f_name
    ,addemployee.f_aadhar_number
    ,addemployee.f_pan_number
    ,addemployee.f_passport
    ,date_format(addemployee.f_issue_date, '%Y/%m/%d') as f_issue_date
    ,date_format(addemployee.f_expiry_date, '%Y/%m/%d') as f_expiry_date
    ,date_format(addemployee.f_date_of_birth, '%Y/%m/%d') as f_date_of_birth
    ,addemployee.f_mobile_number
    ,addemployee.f_image
    ,addemployee.f_emp_status
    ,addemployee.f_passport_alert
FROM
    m_addemployee addemployee
WHERE
    addemployee.f_del_flg = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_del_flg'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
<?php if (is_isset ( 'f_name' , $this->_tpl_vars['param']['where'] )): ?>
AND
    <?php echo smarty_function_sql_where_like(array('field' => "addemployee.f_name",'target' => ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_name'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp))), $this);?>

<?php endif; ?>
<?php if (is_isset ( 'f_emp_id' , $this->_tpl_vars['param']['where'] )): ?>
AND
    addemployee.f_emp_id = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_emp_id'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
<?php endif; ?>
<?php if (is_isset ( 'f_emp_status' , $this->_tpl_vars['param']['where'] )): ?>
AND
    addemployee.f_emp_status = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['where']['f_emp_status'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
<?php endif; ?>
<?php if (is_isset ( 'f_language' , $this->_tpl_vars['param']['where'] )): ?>
AND (
    <?php $_from = $this->_tpl_vars['param']['where']['f_language']; if (($_from instanceof StdClass) || (!is_array($_from) && !is_object($_from))) { settype($_from, 'array'); }$this->_foreach['current'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['current']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cur']):
        $this->_foreach['current']['iteration']++;
?>
        <?php if (! ($this->_foreach['current']['iteration'] <= 1)): ?>
            OR
        <?php endif; ?>
        <?php echo smarty_function_sql_where_like(array('field' => "addemployee.f_language",'target' => ((is_array($_tmp=$this->_tpl_vars['cur'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp))), $this);?>

    <?php endforeach; endif; unset($_from); ?>
)
<?php endif; ?>
ORDER BY
    addemployee.f_emp_status, addemployee.f_emp_id ASC
<?php if (isset ( $this->_tpl_vars['param']['limit']['offset'] ) && isset ( $this->_tpl_vars['param']['limit']['limit'] )): ?>
LIMIT
    <?php echo smarty_function_sql_offset_limit(array('offset' => $this->_tpl_vars['param']['limit']['offset'],'limit' => ((is_array($_tmp=$this->_tpl_vars['param']['limit']['limit'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp))), $this);?>

<?php endif; ?>