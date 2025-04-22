<?php /* Smarty version 2.6.17, created on 
         compiled from m_admin/login.sql */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'addslashes', 'm_admin/login.sql', 18, false),)), $this); ?>
SELECT
     ma.f_admin_id
    ,ma.f_name
    ,ma.f_mailaddress
    ,ma.f_id
    ,ma.f_password
    ,ma.f_admin_kbn
    ,ma.f_auth
    ,ma.f_auth_value
    ,ma.f_del_flg
    ,ma.f_reg_account
    ,ma.f_reg_time
    ,ma.f_upd_account
    ,ma.f_upd_time
FROM
    m_admin ma
WHERE
    ma.f_id = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_id'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
AND
    ma.f_password = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_password'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
AND
    ma.f_del_flg = '<?php echo ((is_array($_tmp=@DEL_FLG_LIST_OFF)) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'