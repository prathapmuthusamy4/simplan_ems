<?php /* Smarty version 2.6.17, created on 
         compiled from m_user/login.sql */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'addslashes', 'm_user/login.sql', 16, false),)), $this); ?>
SELECT
     user.f_user_id
    ,user.f_name
    ,user.f_surname_kana
    ,user.f_mailaddress
    ,user.f_login_id
    ,user.f_password
    ,user.f_del_flg
    ,user.f_reg_account
    ,user.f_reg_time
    ,user.f_upd_account
    ,user.f_upd_time
FROM
    m_user user
WHERE
    user.f_login_id = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_login_id'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
AND
    user.f_password = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_password'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'
AND
    user.f_del_flg = '<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_del_flg'])) ? $this->_run_mod_handler('addslashes', true, $_tmp) : smarty_modifier_addslashes($_tmp)); ?>
'