<?php /* Smarty version 2.6.17, created on 
         compiled from m_addemployee/select_list_count.sql */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'addslashes', 'm_addemployee/select_list_count.sql', 6, false),array('function', 'sql_where_like', 'm_addemployee/select_list_count.sql', 9, false),)), $this); ?>
SELECT
    count(addemployee.f_employee_id) as count
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