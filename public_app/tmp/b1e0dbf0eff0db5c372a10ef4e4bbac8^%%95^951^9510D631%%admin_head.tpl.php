<?php /* Smarty version 2.6.17, created on 
         compiled from file:C:%5Cxampp%5Chtdocs%5Csimplan%5Cpublic_app%5Chtml%5Cadmin_head.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'file:C:\\xampp\\htdocs\\simplan\\public_app\\html\\admin_head.tpl', 5, false),array('modifier', 'date_format', 'file:C:\\xampp\\htdocs\\simplan\\public_app\\html\\admin_head.tpl', 29, false),)), $this); ?>
<!doctype html>
<html>
  <head>
  <meta charset="utf-8" />
  <title><?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</title>
  <link href="./css/layout.css?<?php echo time(); ?>
" rel="stylesheet" type="text/css" media="all" />
  <link href="./css/dropdown.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="./js/com.js?<?php echo time(); ?>
" type="text/JavaScript" charset="UTF-8"></script>
  <script language="JavaScript" src="./js/dropdown.js" type="text/JavaScript" charset="UTF-8"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="./js/jquery.jclock-1.2.0.js.txt" type="text/javascript"></script>
</head>
<body>
<form name="mainfrm" id="mainfrm" action="" method="post" enctype="multipart/form-data">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../jquery_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<input type="hidden" name="prc" />
<input type="hidden" name="cmd" />
<input type="hidden" name="sid" />
<input type="hidden" name="pno" />
  <div id="topwrap">
    <!--default start-->
    <!--header-->
    <div id="header" style="margin:10px 0px 0px 0px;">
      <div id="headerleft">
        <a href="index.php"><img src="img/logo.png" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～" width="100" /></a>
      </div>
      <div id="headerright">
        <p>
          <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d (%a)") : smarty_modifier_date_format($_tmp, "%Y/%m/%d (%a)")); ?>
&nbsp;
          <span class="jclock"></span>
        </p>
        <p>
          <a href="index.php?cmd=logout" style="text-decoration: none;">
            <img src="img/logout.png" alt="logout" title="logout" width="100" height="36" />
          </a>
        </p>
      </div>
    <div id="cc"></div>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['common']['menu_tpl']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
    <div id="cc"></div>
    <!--maindefault-->
    <div id="mainstage">