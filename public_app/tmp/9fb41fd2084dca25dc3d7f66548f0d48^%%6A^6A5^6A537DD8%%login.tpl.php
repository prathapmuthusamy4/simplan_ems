<?php /* Smarty version 2.6.17, created on 
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'login.tpl', 5, false),array('modifier', 'admin_err', 'login.tpl', 64, false),array('modifier', 'date_format', 'login.tpl', 72, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</title>
  <link href="css/layout.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="./js/com.js?<?php echo time(); ?>
" type="text/JavaScript" charset="UTF-8"></script>
  <script language="JavaScript" src="./js/jquery.js?<?php echo time(); ?>
" type="text/JavaScript" charset="UTF-8"></script>
</head>
<body>
<form name="mainfrm" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="prc" />
<input type="hidden" name="cmd" />
<div id="topwrap">
<!--default start-->
<!--header-->
  <div id="header" style="margin-top:50px;">
  <div id="cc"></div>
  <!--maindefault-->
  <div id="mainstaget">
    <img src="img/logo.png" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～" width="80" height="85" style="float: left;padding: 0px;" />
    <h3>SIMPLAN SOFTWARE INDIA PRIVATE LIMITED</h3>
    <div id="logs">
      <table width="500"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="30%" align="center" bgcolor="#2596be"><p>ADMIN NAME<img src="img/ar.gif" width="12" height="12" align="absmiddle" /></p></td>
          <td width="70%" align="left">
            <input id="f_login_id" name="f_id" type="text" class="formst" value="<?php echo $this->_tpl_vars['param']['f_id']; ?>
" />
          </td>
        </tr>
      </table>
      <table width="500"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="30%" align="center" bgcolor="#2596be"><p>PASSWORD<img src="img/ar.gif" width="12" height="12" align="absmiddle" /></p></td>
          <td width="70%" align="left">
            <input name="f_password" type="password" class="formst" onkeypress="return submitfrmWithEnter('index.php', 'index', 'login', event);" />
          </td>
        </tr>
      </table>
      <br /><br />
      <table width="500"  border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="100%" align="center">
            <a href="javascript:void(0);" onclick="return submitfrm('index.php', 'index', 'login');" >
              <img src="img/login1.png" alt="login" title="login" width="100" height="36" />
            </a>
          </td>
        </tr>
        <tr>
          <td width="100%" align="center">
          &nbsp;
          </td>
        </tr>
        <tr>
          <td width="100%" align="center">
            <div id="remind">
            <a href="javascript:void(0);" onclick="return submitfrm('index.php', 'index', 'remind');" title="Forgot your password?">
              <strong>* Forgot your password?</strong>
            </a>
            </div>
          </td>
        </tr>
      </table>
      <h4><?php echo ((is_array($_tmp=$this->_tpl_vars['param']['errmsg']['login'])) ? $this->_run_mod_handler('admin_err', true, $_tmp) : smarty_modifier_admin_err($_tmp)); ?>
</h4>
    </div>
    <!--maindefault end-->
  </div>
  <!--css reset-->
  <div id="cc"></div>
  <!--footer-->
  <div id="footer">
    <p align="right">Copyrights &copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y') : smarty_modifier_date_format($_tmp, '%Y')); ?>
 <?php echo $this->_tpl_vars['common']['name_en']; ?>
. All Right Reserved</p>
    <p align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&nbsp;Version&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_version'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
    <p align="right"><?php echo $this->_tpl_vars['common']['simplan_logo']; ?>
</p>
  </div>
  <!--default end-->
</div>
<?php echo '
<script type="text/javascript">
window.onload = function() {
  document.getElementById("f_login_id").focus();
};
</script>
'; ?>

</form>
</body>
</html>